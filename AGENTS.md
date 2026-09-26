# AGENTS.md — TYPO3 Explained

Source for the **"TYPO3 Explained"** manual, rendered to docs.typo3.org.
Lives in the git repo TYPO3-Documentation/TYPO3CMS-Reference-CoreApi — a
legacy name that doesn't match the manual title (see
`Documentation/Index.rst`/`About.rst`). `main` targets the next TYPO3
major version.

## Every commit message

Copy this skeleton and fill it in. These trailers are required on every commit
in this repository, and they take precedence over any personal commit
convention an agent carries from a user-level `CLAUDE.md` or similar:

```
[TASK] Imperative one-line summary

Why the change is needed. The diff shows what changed.

Releases: main, 14.3
Assisted-by: Some AI Model <noreply@someai.com>
Signed-off-by: Firstname Lastname <email>
```

- Prefix: a commit that documents a change in TYPO3 Core copies the subject of
  that change including its tags, for example
  `[!!!][TASK] Use stronger cryptographic algorithm for HMAC`. The `[!!!]`
  marker belongs to the TYPO3 Core commit rules and only ever arrives here as
  part of a copied subject. A subject of our own takes `[DOCS]` for
  documentation of something the manual did not cover yet, `[TASK]` for a
  cleanup, a style fix or tooling, and `[BUGFIX]` for a correction of wrong
  content.
- `Releases:` is mandatory. Default `main, 14.3`. Read rule 4 before adding `13.4`.
- `Assisted-by:` whenever AI helped draft the commit, in exactly the shape
  above: the model's own name and version, then a contact address. **Replace
  the name in the skeleton with the model that is actually writing this
  commit** — the skeleton shows one example, and leaving it in place files a
  false attribution. Do not substitute a slug such as `vendor-tool:model-id`
  from a personal configuration.
- `Signed-off-by:` names the human author.
- Keep the trailers in the order shown. Rules 4 and 5 below give the reasoning.

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
- `make test-rst-style` — check the two indentation rules of the style guide
  that can be decided without reading the page: two spaces after `..`, and
  directive options four spaces deeper than their directive. Everything else
  reST indents has its own width, so a general rule would report noise
  instead of findings. The body of a literal directive is left alone, and
  `Documentation/CodeSnippets/` is skipped entirely, because a generator
  writes those files and decides their format.
- `make test-editorconfig` — check indentation and whitespace against
  `.editorconfig`. It runs only over code files: `.editorconfig-checker.json`
  excludes reST, because the checker cannot tell a directive body from an
  embedded code block and would flag every snippet whose indentation is not a
  multiple of four. `max_line_length` is disabled there too — it stays in
  `.editorconfig` as advice for editors, not as a gate, since reflowing prose
  is an editorial decision. Add an exclude for a file whose indentation is
  content rather than formatting, the way `.plantuml` is excluded because
  every leading space shifts the rendered note label, and `.diff` because a
  leading space is part of the patch. A TypoScript multiline value keeps its
  indentation in the value as well. Never reformat an example whose subject
  is its own formatting, and check what a file's whitespace actually does
  before touching it.
- `make test` — full test suite (docs, lint, cgl, yaml, typoscript, json,
  reST style, editorconfig).

## Finding your way in the published manual

- **Do not guess a rendered path or an anchor.** Every manual publishes its
  object inventory, so the target of a `:ref:` and the page a section sits on
  can be looked up in one call:

  ```bash
  curl -s https://docs.typo3.org/m/typo3/reference-coreapi/main/en-us/objects.inv.json \
    | jq -r '."std:label" | to_entries[] | select(.key|test("base-variants"; "i")) | "\(.key) -> \(.value[2])"'
  ```

  `std:doc` maps document names the same way. Swapping the base URL answers
  the same question for any other manual, which is how a moved page or the
  right target for a cross-manual reference is found without rendering.

- **A permalink can be checked without rendering.** A `HEAD` request against
  `https://docs.typo3.org/permalink/<interlink>:<anchor>` answers `307` with a
  `Location` naming the page the anchor resolves to; a wrong anchor answers
  `404`:

  ```bash
  curl -sI https://docs.typo3.org/permalink/t3coreapi:sitehandling-base-variants-functions | grep -Ei '^(HTTP|Location)'
  ```

- **A permalink can name a version.** Append `@<version>` to link the page as
  it stands on a release branch, for example
  `…:sitehandling-base-variants-functions@13.4`. Read the `Location` header to
  confirm which version answered: an unknown version does not fail, it
  redirects to `main`, so `@99.9` looks like a working link to the wrong page.
  The inventory of that version sits at the same URL with `main` replaced,
  `…/reference-coreapi/13.4/en-us/objects.inv.json`, which is how an anchor is
  checked for a branch before a backport links it.

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
    `Assisted-by: Some AI Model <noreply@someai.com>`, naming the model that
    actually assisted, whenever AI assisted in drafting the commit, then
    the human author's `Signed-off-by: <Name>`. This isn't a DCO
    requirement tracked elsewhere in this repo — it's an observed
    convention from merged commit history, so follow the trailer order
    above rather than only the `Releases:`/label rules in 4.
6.  **Taking over someone else's commits**: this repository merges by
    squash, so a contributor whose commits you carry into your own branch
    survives on the target branch only as a `Co-authored-by:` trailer in the
    squash message. GitHub writes those trailers itself, because the squash
    message is composed from the commit messages — PR #7017 reached `main`
    with `Co-authored-by: Sarah McCarthy` that way. They are lost when the
    person merging replaces the proposed message, so keep the generated
    `Co-authored-by:` lines when editing it, and add a missing one by hand.
7.  **Merging the bot's backport PRs**: once a labelled PR is merged,
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
