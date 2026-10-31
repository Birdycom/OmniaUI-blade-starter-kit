# OmniaUI Blade starter kit

A Laravel 13 starter kit in plain Blade, built with [OmniaCSS](https://omniacss.eu) and [OmniaUI](https://omniaui.eu) instead of
Tailwind. The features of Laravel's official Livewire kit, on Fortify, with plain controllers and forms: no Livewire, no SPA. Alpine.js handles the few interactive bits (passkeys, copy buttons).

- Log in, register, forgot / reset password, email verification, password confirmation
- Two-factor authentication (QR code, setup key, recovery codes) and passkeys
- Settings: profile, password, two-factor, passkeys, appearance (light / dark / system), delete account
- An app shell with a collapsible sidebar (a sheet on phones), a top-bar layout, and three auth layouts (simple, card, split)
- A dashboard made of free OmniaUI components: KPI tiles, an SVG line chart, status rows and a table

```bash
laravel new my-app --using=birdycom/omniaui-blade-starter-kit
cd my-app && composer run dev
```

## How the styling works

- `resources/css/app.css` has two directives: `@omniaui;` (the OmniaUI components) and `@omnia;` (the OmniaCSS utilities).
  The PostCSS plugin replaces them with only the CSS your views use. The whole kit ships about **56 kB of CSS (11 kB gzip)**, components included.
- `postcss.config.js` scans `resources/views` and the OmniaUI Blade components your views use (`<x-oc::button>` …).
- Colors, radius and fonts are theme tokens: override them in `resources/css/theme.css`. Every component follows
  light and dark mode through `light-dark()`; Settings > Appearance stores the choice as `data-theme` on `<html>`.
- `resources/css/layout.css` holds the few layout rules of the kit itself (auth column, settings grid …).

## Components

The views use the Blade components of [`birdycom/omniaui-laravel`](https://omniaui.eu/ui/frameworks-laravel) (`<x-oc::…>`). Modals are native `<dialog>` elements opened with `command="show-modal"`.
Add more with `npx omniaui add <name> --framework blade`, or copy the HTML of any component from omniaui.eu.

OmniaUI Pro blocks (CMS dashboard, charts, kanban …) work in this kit too once you have a license: install
`birdycom/omniaui-pro-laravel` and they appear in the same `@omniaui;` build.

## AI assistants

The kit is written so assistants can extend it without falling back to Tailwind:

```bash
claude mcp add omniacss -- npx -y @birdycom/omniacss-mcp
```

The MCP server checks every class and gives the reference markup of every component. Without MCP, point your assistant
at https://omniacss.eu/llms.txt and https://omniaui.eu/llms.txt.

## License

MIT. Based on the MIT-licensed [laravel/livewire-starter-kit](https://github.com/laravel/livewire-starter-kit); the settings pages are rewritten as controllers.
