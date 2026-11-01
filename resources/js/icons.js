import { addCollection, setCustomIconsLoader } from 'iconify-icon';
import sets from 'virtual:omnia-icons';

// The webicons this app uses (collected by vite-icons.js, see <x-icon>), one collection per set (mdi, mdi-light,
// material-symbols …). Each used set also gets a loader, so the Iconify API is never called.
for (const set of sets) {
    addCollection(set);
    setCustomIconsLoader(() => set, set.prefix);
}
