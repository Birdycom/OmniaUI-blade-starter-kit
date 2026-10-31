import fs from 'node:fs';
import path from 'node:path';
import omniacss from '@birdycom/omniacss/postcss';

// OmniaCSS builds only the utilities and OmniaUI components the app uses. The OmniaUI Blade components live in
// vendor/birdycom; scanning all of them would keep every component, so only the ones the views use (<x-oc::name>)
// are added, plus the components those use in turn.
const views = 'resources/views';
const packages = ['vendor/birdycom/omniaui-laravel'].map((p) => `${p}/resources/views/components`);

const read = (file) => fs.readFileSync(file, 'utf8');
const bladeFiles = (dir) => (fs.existsSync(dir) ? fs.readdirSync(dir, { recursive: true }).filter((f) => f.endsWith('.blade.php')).map((f) => path.join(dir, f)) : []);
const componentFile = (name) => {
    const rel = name.replaceAll('.', '/');
    for (const dir of packages) {
        for (const file of [`${dir}/${rel}.blade.php`, `${dir}/${rel}/index.blade.php`]) {
            if (fs.existsSync(file)) return file;
        }
    }
    return null;
};

function usedComponents() {
    const used = new Set();
    const queue = bladeFiles(views);
    while (queue.length) {
        for (const [, name] of read(queue.pop()).matchAll(/<x-oc::([\w.-]+)/g)) {
            const file = componentFile(name);
            if (file && !used.has(file)) {
                used.add(file);
                queue.push(file);
            }
        }
    }
    return [...used];
}

export default {
    plugins: [
        omniacss({
            content: ['resources/views/**/*.blade.php', 'resources/js/**/*.js', ...usedComponents()],
        }),
    ],
};
