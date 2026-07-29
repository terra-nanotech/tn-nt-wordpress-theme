# Contributing<a name="contributing"></a>

There are many ways you can contribute to this project. The following is a set of
guidelines for contributing. Please follow them to make the contribution process
easy and effective for everyone involved.

Contributions are welcome from everyone. By participating in this project, you
agree to abide by its [code of conduct].

You can contribute to this project in many ways, including but not limited to:

- Reporting bugs
- Suggesting new features
- Translating the app into other languages
- Writing code (Help with development)

______________________________________________________________________

<!-- mdformat-toc start --slug=github --maxlevel=6 --minlevel=2 -->

- [Translations](#translations)
- [Development](#development)
  - [License Agreements](#license-agreements)
    - [Project License](#project-license)
  - [Development Environment](#development-environment)
  - [Make Targets](#make-targets)
  - [Code Formatting and Linting](#code-formatting-and-linting)
    - [PHP](#php)
    - [JavaScript](#javascript)
      - [Minified JS](#minified-js)
    - [CSS](#css)
      - [Minified CSS](#minified-css)
    - [pre-commit](#pre-commit)
  - [Branching and Pull Requests](#branching-and-pull-requests)
    - [Checklist](#checklist)

<!-- mdformat-toc end -->

______________________________________________________________________

## Translations<a name="translations"></a>

This app is fully translation-ready and translations are handled via [Weblate]. If
you like to contribute to the app's translation or improve it, feel free to
register on my [Weblate] instance and start translating.

## Development<a name="development"></a>

### License Agreements<a name="license-agreements"></a>

#### Project License<a name="project-license"></a>

This project is licensed under the GNU General Public License v3.0 (GPLv3). See the
[LICENSE](LICENSE) file for details.

By contributing code to this project, you agree that your contributions will be
licensed under the same license as the project itself.

### Development Environment<a name="development-environment"></a>

To develop and test your change, you will need a development environment on your
local machine. There are different options to choose from. But please make sure
you can run pre-commit checks and tox tests on your local machine.

### Make Targets<a name="make-targets"></a>

This project uses `Makefile` to simplify common tasks. You can run `make` in the
project root to see all available targets.

### Code Formatting and Linting<a name="code-formatting-and-linting"></a>

#### PHP<a name="php"></a>

When making changes to the source code, please make sure that your code adheres to the
coding style and that it is free of syntax errors.

You can use the following tools to check your code:

```shell
pre-commit run php-cs
pre-commit run php-lint-all
```

#### JavaScript<a name="javascript"></a>

The JavaScript code follows [ECMAScript 6 (or ES6 for short)][ecmascript 6] or newer
rules. The use of arrow functions is preferred and `this` or `$(this)` should be
prevented. Functions need to be declared before their use, and the JavaScript code
should follow `'use strict';`.

Indent size: 4 spaces

A linter configuration is declared as `.eslintrc.json` in the app's root directory.
Do not change this file.

To check that your JavaScript code adheres to the rules, run:

```shell
pre-commit run eslint
```

##### Minified JS<a name="minified-js"></a>

This project uses minified and compressed JavaScript files with source maps created by
[Terser]. Make sure to add/update them as well if you add or change JavaScript.

To do so, run:

```shell
terser script.js -o script.min.js --source-map "url='script.min.js.map'" --compress reduce_vars=false --mangle --format quote_style=1
```

#### CSS<a name="css"></a>

The CSS should be written in a modern manner. Color definitions should be in
modern RGB notation (e.g., `rgb(255 255 255)`, `rgb(255 255 255 / 50%)`).

A linter configuration is declared as `.stylelintrc.json` in the app's root
directory. Do not change this file.

Indent size: 4 spaces

To check that your JavaScript code adheres to the rules, run:

```shell
pre-commit run stylelint
```

##### Minified CSS<a name="minified-css"></a>

This project uses minified CSS files with source maps created by [SASS]. Make sure
to add/update them as well if you add or change CSS.

```shell
sass --style=compressed styles.css:styles.min.css
```

#### pre-commit<a name="pre-commit"></a>

This repository uses [pre-commit] to verify compliance with formatting / linting rules.
To use:

- Install `pre-commit` to your system.
- Run `pre-commit install` inside the app's root directory.
- You're all done! Code will be checked automatically using git hooks.

You can check if your code to commit adheres to the given style by simply running:

```shell script
pre-commit
```

Or to check all files:

```shell script
pre-commit run --all-files
```

The following will be checked by `pre-commit` (among others):

- No trailing whitespaces (excluded are minified JS and CSS, PO and MO files, and
  external libs)
- One, and only one, empty line at the end of every file (excluded are minified JS
  and CSS, PO and MO files, and external libs)
- Line ending is LF
- Code generally adheres to the editor config
- Code passes linting and formatting checks (PHP, JS, CSS, etc.)
- Markdown files are formatted properly

### Branching and Pull Requests<a name="branching-and-pull-requests"></a>

To contribute code via pull request, make sure you fork the repository and branch your
changes from the `master` branch.

We strongly recommend creating a new branch for every new feature or change you
plan to be submitting as merge request. Please make sure to keep the `master` branch of
your fork in sync with the main repository to avoid conflicts.

Before you start working on a new feature, please open an Issue (Type: Feature
Request) and start a discussion if your idea is generally wanted and considered a
good addition to the app in general.

Please feel free to create your merge request early and while you are still not
finished developing to flag that you are working on a specific topic. Merge requests
that are not yet ready to review should be marked as DRAFT. You can signal others
that your merge request is ready for review by removing the DRAFT flag again.

#### Checklist<a name="checklist"></a>

Before you submit a pull request, please make sure that:

- [ ] Your code follows the style guidelines of this project
- [ ] Your changes are supported and covered by tests
- [ ] You have performed a self-review of your own code
- [ ] You have commented on your code, particularly in hard-to-understand areas
- [ ] You have checked your code and corrected any misspellings

<!-- Links -->

[code of conduct]: CODE_OF_CONDUCT.md "Code of Conduct"
[ecmascript 6]: https://www.w3schools.com/js/js_es6.asp "JavaScript ECMAScript 6"
[pre-commit]: https://github.com/pre-commit/pre-commit "pre-commit"
[sass]: https://www.npmjs.com/package/sass "SASS"
[terser]: https://github.com/terser/terser "Terser"
[weblate]: https://weblate.ppfeufer.de/ "Weblate"
