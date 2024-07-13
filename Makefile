.PHONY: help
help: ## Displays this list of targets with descriptions
	@echo "The following commands are available:\n"
	@grep -E '^[a-zA-Z0-9_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}'

.PHONY: docs
docs: ## Generate projects documentation (from "Documentation" directory)
	mkdir -p Documentation-GENERATED-temp

	docker run --rm --pull always -v "$(shell pwd)":/project -t ghcr.io/typo3-documentation/render-guides:latest --config=Documentation

.PHONY: test-docs
test-docs: ## Test the documentation rendering
	mkdir -p Documentation-GENERATED-temp

	docker run --rm --pull always -v "$(shell pwd)":/project -t ghcr.io/typo3-documentation/render-guides:latest --config=Documentation --no-progress --fail-on-log

.PHONY: generate
generate: codesnippets command-json ## Regenerate automatic code documentation

.PHONY: codesnippets
codesnippets: ## Regenerate code snippets
	ddev exec .Build/bin/typo3 codesnippet:create Documentation/

.PHONY: command-json
command-json: ## Regenerate JSON file containing all console commands
	ddev exec .Build/bin/typo3 list --format=json > Documentation/ApiOverview/CommandControllers/commands.json

.PHONY: test-lint
test-lint: ## Regenerate code snippets
	Build/Scripts/runTests.sh -s lint

.PHONY: test-cgl
test-cgl: ## Regenerate code snippets
	Build/Scripts/runTests.sh -s cgl

.PHONY: test-yaml
test-yaml: ## Regenerate code snippets
	Build/Scripts/runTests.sh -s yamlLint

.PHONY: install
install: ## Úpdate all dependencies (the composer.lock is not commited)
	Build/Scripts/runTests.sh -s composerUpdate

.PHONY: test
test: test-docs test-lint test-cgl test-yaml## Test the documentation rendering
