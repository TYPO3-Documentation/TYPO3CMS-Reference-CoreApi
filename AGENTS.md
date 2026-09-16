# AGENTS.md — TYPO3 Explained

Source for the **"TYPO3 Explained"** manual, rendered to docs.typo3.org.
Lives in the git repo TYPO3-Documentation/TYPO3CMS-Reference-CoreApi — a
legacy name that doesn't match the manual title (see
`Documentation/Index.rst`/`About.rst`). `main` targets the next TYPO3
major version.

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
- `make test-typoscript` — check the `.typoscript` and `.tsconfig` snippets
  for syntax errors. TypoScript drops whatever it cannot parse without
  complaining, so a broken example stays invisible until somebody copies
  it; the check round trips each file through the Core tokenizer and
  counts the block braces. A file that demonstrates invalid syntax on
  purpose opts out with `# typoscript-lint: ignore-file` in its first line.
- `make test-json` — check the `.json` snippets for syntax errors. JSON has
  no comment syntax, so an excerpt cannot mark what it leaves out and still
  has to be a well formed document: wrap the part you show in the braces it
  belongs in and put `(excerpt)` in the caption. To show that more members
  follow, write a `"...": "..."` member, which is ordinary JSON.
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
- `make test` — full test suite (docs, lint, cgl, yaml, typoscript, json,
  editorconfig).

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
5.  **Commit trailers**: end every commit message with, in this order —
    the `Resolves:`/`References:` line for a `Changelog-To-Doc` issue if
    applicable (see rule 4's changelog note), `Releases:`, then
    `Assisted-by: Claude Sonnet 5 <noreply@anthropic.com>` (or the actual
    assisting model) whenever AI assisted in drafting the commit, then
    the human author's `Signed-off-by: <Name>`. This isn't a DCO
    requirement tracked elsewhere in this repo — it's an observed
    convention from merged commit history, so follow the trailer order
    above rather than only the `Releases:`/label rules in 4.
6.  **Merging the bot's backport PRs**: once a labelled PR is merged,
    `typo3-docs-backport-bot` opens the `[Backport <version>]` PRs.
    Afterwards confirm the commit actually reached the release branch
    (`git log origin/14.3 --grep=...`): a `backport-done` label is not
    proof, and a backport can fail without opening a pull request at
    all, leaving the branch behind with nothing to notice. When several
    backports touch the same file, merge them in the order their
    originals landed on `main`, and let `mergeable_state` leave
    `unknown` before merging the next one — GitHub recomputes it for a
    minute or two after a merge moved the base.

## References

- [TYPO3CMS-Guide-HowToDocument](https://docs.typo3.org/m/typo3/docs-how-to-document/main/en-us/) — content style & RST conventions
- [AGENTS.md](https://github.com/TYPO3-Documentation/TYPO3CMS-Guide-HowToDocument/blob/main/AGENTS.md) — shared agent rules for TYPO3-Documentation repos
