# AGENTS.md — TYPO3 Core API Reference

TYPO3 Core API reference documentation
(TYPO3-Documentation/TYPO3CMS-Reference-CoreApi), rendered to
docs.typo3.org. `main` targets the next TYPO3 major version.

## Repo structure

```
Documentation/              # the manual (reST source, published to docs.typo3.org)
.Build/vendor/typo3/cms-*   # composer-installed TYPO3 Core, for verifying facts against real source
Makefile                    # local install/build/test commands
```

## Commands

- `make install` — install dependencies. Also re-run after switching to a
  branch targeting a different TYPO3 version (`main`/`14.3`/`13.4` each pin
  a different Core version under `.Build/vendor`) — otherwise you're
  checking facts against the wrong version.
- `make docs` — render the manual locally with Docker.
- `make test-docs` — render in minimal-test mode (the same validation CI
  runs); use this to validate any change before committing. `docs-test`
  still works as a deprecated alias for the target's former name.
- `make test-editorconfig` — check indentation and whitespace against
  `.editorconfig`. It runs only over code files: `.editorconfig-checker.json`
  excludes reST, because the checker cannot tell a directive body from an
  embedded code block and would flag every snippet whose indentation is not a
  multiple of four. `max_line_length` is disabled there too — it stays in
  `.editorconfig` as advice for editors, not as a gate, since reflowing prose
  is an editorial decision. Add an exclude for a file whose indentation is
  content rather than formatting: in the TypoScript multiline value example
  the leading spaces end up in the value, in the comment example the
  indentation is the very notation the page demonstrates, and PlantUML keeps
  the indentation of note text, where every space shifts the rendered label.
  Never reformat an example whose subject is its own formatting, and check
  what a file's whitespace actually does before touching it.
- `make test` — full test suite (docs, lint, cgl, yaml, editorconfig).

## Rules

1.  **Content style**: follow the central
    [TYPO3CMS-Guide-HowToDocument](https://docs.typo3.org/m/typo3/docs-how-to-document/main/en-us/)
    guide and its
    [AGENTS.md](https://github.com/TYPO3-Documentation/TYPO3CMS-Guide-HowToDocument/blob/main/AGENTS.md)
    — sentence case headlines, 4-space indentation (2 spaces after `..`),
    single backticks over double, every headline needs an anchor, etc.
    Don't duplicate those rules here; if one is missing or wrong, fix it in
    that repo instead of adding a local workaround.
2.  **Verify facts** — class names, method signatures, whether something is
    deprecated, when something changed — against `.Build/vendor/typo3/cms-*`
    (incl. its `Documentation/Changelog/`) or real commit history on
    `github.com/TYPO3/typo3`, not memory.
3.  **Never commit or push without being asked.**
4.  **Backporting**: follow the central guide's
    [Backport changes](https://docs.typo3.org/m/typo3/docs-how-to-document/main/en-us/Maintainers/BackportChanges.html) —
    a `backport <version>` label (e.g. `backport 14.3`) on the PR is what
    actually triggers the CI runner once it merges, but only repo members
    can add labels. Always include the `Releases:` trailer in the commit
    message regardless of permissions — if you can't add labels yourself,
    it's the signal a maintainer uses to label the PR (or backport
    manually) when merging. Unlike the central how-to-document repo (no
    LTS branches, skips this entirely), this repo has `main`, `14.3`,
    `13.4` (verify this is still current) — default to `main, 14.3`; add
    `13.4` only for a bugfix/security fix worth backporting that far, not
    for plain content/style changes. If a PR gets no `backport <version>`
    label, label it `main only` instead (mutually exclusive with
    `backport <version>` — not both). Separately, label every PR that
    addresses a `TYPO3-Documentation/Changelog-To-Doc` issue with
    `changelog`, regardless of its backport status.

## References

- [TYPO3CMS-Guide-HowToDocument](https://docs.typo3.org/m/typo3/docs-how-to-document/main/en-us/) — content style & RST conventions
- [AGENTS.md](https://github.com/TYPO3-Documentation/TYPO3CMS-Guide-HowToDocument/blob/main/AGENTS.md) — shared agent rules for TYPO3-Documentation repos
