# Perennial

A WordPress block that keeps a copyright notice current — the year is worked out when the page
is served, so it can never go stale and it is never written into your post content.

**This repository is the published source of the plugin.** It holds the plugin exactly as
distributed on WordPress.org, *plus* the sources its compiled assets were built from.

## Why it exists

WordPress.org asks that a plugin's shipped JavaScript be readable rather than only minified.
Bundling the sources inside the plugin would put them on every install that will never read
them, so they live here instead, and `readme.txt` links this repository under
**== Source code ==**.

## The claim this repository makes

A clean install and a rebuild reproduce the shipped bundles byte for byte:

```sh
pnpm install --frozen-lockfile
pnpm run build
git diff --exit-code build/
```

That is checked before anything is published here — an unverified claim would be worse than no
claim, because this is exactly what a reviewer checks.

## What is here

| | |
|---|---|
| `ghostlabs-perennial.php`, `inc/`, `shared/` | the plugin as it ships |
| `build/` | the compiled block assets, as they ship |
| `src/` | the sources `build/` is compiled from |
| `package.json`, `pnpm-lock.yaml`, `webpack.config.cjs` | everything needed to reproduce that compile |
| `languages/` | the POT |
| `uninstall.php` | removes the single option the plugin stores |

## What is not

- **Tests.** They are not a build input, and shipping them drags the whole dev toolchain behind
  them. They live in the private monorepo this is generated from.
- **Prose comments.** The code is published unobfuscated and unminified, which is what the
  guideline asks for; the reasoning behind it is kept where it is read, in the monorepo.
- **`node_modules`, `vendor/bin`, build tooling for the monorepo itself.**

## Contributing

This repository is generated. Commits made here are overwritten by the next release, so a pull
request against it cannot be merged in the usual sense — but an issue is welcome and will be
fixed at the source.

## Licence

GPL-2.0-or-later, the same as WordPress.
