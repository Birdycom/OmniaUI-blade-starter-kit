// The OmniaCSS webicons for <iconify-icon>, bundled with the app: no calls to the Iconify API.
// The webicons are these Iconify sets: Material Design Icons (mdi:), MDI Light (mdi-light:), Material Symbols
// (material-symbols:), SVG Spinners (svg-spinners:), Flags (flag:) and VSCode Icons (vscode-icons:); see
// omniaui.eu/ui/webicons. Every "<set>:<name>" in resources/ ends up in the module `virtual:omnia-icons` (one Iconify
// collection per set, with only those icons); resources/js/icons.* hands it to iconify-icon. A new icon name in a view
// reloads the page in `npm run dev`.
// Map: scan resources -> build the collections -> Vite plugin (resolve, load, watch)
import { readdirSync, readFileSync } from 'node:fs';
import { createRequire } from 'node:module';
import { isAbsolute, join, relative, resolve } from 'node:path';

const ID = 'virtual:omnia-icons';
const RESOLVED_ID = '\0' + ID;
const SETS = ['mdi', 'mdi-light', 'material-symbols', 'svg-spinners', 'flag', 'vscode-icons'];
const ICON_NAME = new RegExp(`(?<![\\w-])(${SETS.join('|')}):([a-z0-9]+(?:-[a-z0-9]+)*)`, 'g');
const SOURCE_FILE = /\.(php|js|jsx|ts|tsx|vue)$/;

function scan(dir, found) {
    for (const entry of readdirSync(dir, { withFileTypes: true })) {
        const path = join(dir, entry.name);
        if (entry.isDirectory()) {
            scan(path, found);
        } else if (SOURCE_FILE.test(entry.name)) {
            for (const match of readFileSync(path, 'utf8').matchAll(ICON_NAME)) {
                found.add(`${match[1]}:${match[2]}`);
            }
        }
    }
    return found;
}

/** The used icons as Iconify collections, one per set; aliases (e.g. "mdi:cog-outline" -> parent) bring their parent icon. */
function collections(names, load, warn) {
    const bySet = new Map();
    for (const full of names) {
        const [prefix, name] = full.split(':');
        const set = load(prefix);
        if (!set) {
            warn(`omnia-icons: "${full}" needs the ${prefix} set: npm install -D @iconify-json/${prefix}`);
            continue;
        }
        const out = bySet.get(prefix) ?? { prefix, width: set.width ?? 16, height: set.height ?? 16, icons: {}, aliases: {} };
        bySet.set(prefix, out);
        if (set.icons[name]) {
            out.icons[name] = set.icons[name];
        } else if (set.aliases?.[name] && set.icons[set.aliases[name].parent]) {
            out.aliases[name] = set.aliases[name];
            out.icons[set.aliases[name].parent] = set.icons[set.aliases[name].parent];
        } else {
            warn(`omnia-icons: "${full}" is not in the ${prefix} set (see omniaui.eu/ui/webicons).`);
        }
    }
    return [...bySet.values()];
}

export default function omniaIcons({ dirs = ['resources'] } = {}) {
    const require = createRequire(import.meta.url);
    const sets = new Map();
    // A set's JSON is read once, the first time one of its icons is used; null when its package is not installed.
    const load = (prefix) => {
        if (!sets.has(prefix)) {
            try {
                sets.set(prefix, JSON.parse(readFileSync(require.resolve(`@iconify-json/${prefix}/icons.json`), 'utf8')));
            } catch {
                sets.set(prefix, null);
            }
        }
        return sets.get(prefix);
    };
    const roots = dirs.map((dir) => resolve(dir));
    let used = '';
    // path.relative compares drive letters without case (the watcher may report d:\ where the root is D:\).
    const inRoots = (file) => roots.some((dir) => {
        const path = relative(dir, resolve(file));
        return path !== '' && !path.startsWith('..') && !isAbsolute(path);
    });
    const collect = () => [...roots.reduce((found, dir) => scan(dir, found), new Set())].sort((a, b) => a.localeCompare(b));

    return {
        name: 'omnia-icons',
        resolveId(id) {
            return id === ID ? RESOLVED_ID : null;
        },
        load(id) {
            if (id !== RESOLVED_ID) return null;
            const names = collect();
            used = names.join();
            return `export default ${JSON.stringify(collections(names, load, (message) => this.warn(message)))};`;
        },
        configureServer(server) {
            const changed = (file) => {
                if (!SOURCE_FILE.test(file) || !inRoots(file)) return;
                if (collect().join() === used) return;
                const module = server.moduleGraph.getModuleById(RESOLVED_ID);
                if (module) server.moduleGraph.invalidateModule(module);
                server.ws.send({ type: 'full-reload' });
            };
            server.watcher.on('add', changed);
            server.watcher.on('change', changed);
        },
    };
}
