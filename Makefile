# ==============================================================================
# TYPO3 Documentation - Makefile
# ==============================================================================
# Run `make` or `make help` to see available commands
#
# Prerequisites:
#   - Docker (for docs rendering)
#   - DDEV (for code generation tasks)
# ==============================================================================

# ------------------------------------------------------------------------------
# Configuration
# ------------------------------------------------------------------------------
DOCKER_IMAGE := ghcr.io/typo3-documentation/render-guides:latest
DOCKER_USER := $(shell id -u):$(shell id -g)
DOCS_DIR := Documentation
DOCS_OUTPUT := Documentation-GENERATED-temp
COMPOSER_AUTOLOAD := .Build/vendor/autoload.php

.DEFAULT_GOAL := help

# ------------------------------------------------------------------------------
# Dependency Checks
# ------------------------------------------------------------------------------
.PHONY: check-dependencies
check-dependencies:
	@if [ ! -f "$(COMPOSER_AUTOLOAD)" ]; then \
		echo ""; \
		echo "ERROR: Dependencies not installed."; \
		echo ""; \
		echo "Please run:"; \
		echo "  make install"; \
		echo ""; \
		exit 1; \
	fi

# ------------------------------------------------------------------------------
# Help
# ------------------------------------------------------------------------------
.PHONY: help
help: ## Display available commands
	@echo "Usage: make [target]\n"
	@echo "Targets:"
	@grep -E '^[a-zA-Z0-9_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "  \033[32m%-20s\033[0m %s\n", $$1, $$2}'

# ------------------------------------------------------------------------------
# Documentation
# ------------------------------------------------------------------------------
.PHONY: docs
docs: ## Build documentation locally
	mkdir -p $(DOCS_OUTPUT)
	docker run --user $(DOCKER_USER) --rm --pull always -v "$(shell pwd)":/project -t $(DOCKER_IMAGE) --config=$(DOCS_DIR)

.PHONY: docs-test
docs-test: ## Build documentation with strict validation (CI mode)
	mkdir -p $(DOCS_OUTPUT)
	docker run --user $(DOCKER_USER) --rm --pull always -v "$(shell pwd)":/project -t $(DOCKER_IMAGE) --config=$(DOCS_DIR) --no-progress --fail-on-log

docs-hot: ## Generate projects documentation with hot reloading
	docker run --rm -it --pull always \
  		-v "./Documentation:/project/Documentation" \
  		-v "./Documentation-GENERATED-temp:/project/Documentation-GENERATED-temp" \
  		-p 1337:1337 ghcr.io/typo3-documentation/render-guides:latest --config="Documentation" --watch

.PHONY: docs-open
docs-open: ## Open rendered documentation in browser
	@if [ -f "$(DOCS_OUTPUT)/Index.html" ]; then \
		xdg-open "$(DOCS_OUTPUT)/Index.html" 2>/dev/null || open "$(DOCS_OUTPUT)/Index.html" 2>/dev/null || echo "Open $(DOCS_OUTPUT)/Index.html in your browser"; \
	else \
		echo "Documentation not found. Run 'make docs' first."; \
	fi

# ------------------------------------------------------------------------------
# Code Generation (requires DDEV)
# ------------------------------------------------------------------------------
.PHONY: generate
generate: setup-typo3 codesnippets command-json ## Regenerate all auto-generated documentation

.PHONY: codesnippets
codesnippets: check-dependencies ## Regenerate PHP code snippets
	ddev exec .Build/bin/typo3 codesnippet:create $(DOCS_DIR)/

.PHONY: command-json
command-json: check-dependencies ## Regenerate console commands JSON
	ddev exec .Build/bin/typo3 clinspector:gadget > $(DOCS_DIR)/ApiOverview/CommandControllers/commands.json
	echo "" >> $(DOCS_DIR)/ApiOverview/CommandControllers/commands.json

# ------------------------------------------------------------------------------
# Setup (requires DDEV)
# ------------------------------------------------------------------------------
.PHONY: install
install: composer-update ## Install project dependencies

.PHONY: composer-update
composer-update: ## Update Composer dependencies
	Build/Scripts/runTests.sh -s composerUpdate

.PHONY: setup-typo3
setup-typo3: check-dependencies ## Initialize TYPO3 for documentation generation
	ddev exec '.Build/bin/typo3 setup --driver=sqlite --username=db --password=db --admin-username=john-doe --admin-user-password="John-Doe-1701D." --admin-email="john.doe@example.com" --project-name="TYPO3 Docs" --no-interaction --server-type=apache --force'

# ------------------------------------------------------------------------------
# Testing
# ------------------------------------------------------------------------------
.PHONY: test
test: docs-test test-lint test-cgl test-yaml ## Run all tests

.PHONY: test-lint
test-lint: ## Check PHP syntax
	Build/Scripts/runTests.sh -s lint

.PHONY: test-cgl
test-cgl: check-dependencies ## Check TYPO3 Coding Guidelines (dry-run)
	Build/Scripts/runTests.sh -s cgl -n

.PHONY: test-yaml
test-yaml: check-dependencies ## Validate YAML files
	Build/Scripts/runTests.sh -s yamlLint

# ------------------------------------------------------------------------------
# Fixing
# ------------------------------------------------------------------------------
.PHONY: fix
fix: fix-cgl ## Apply all automatic fixes

.PHONY: fix-cgl
fix-cgl: check-dependencies ## Fix TYPO3 Coding Guidelines violations
	Build/Scripts/runTests.sh -s cgl

# ------------------------------------------------------------------------------
# Cleanup
# ------------------------------------------------------------------------------
.PHONY: clean
clean: ## Remove generated documentation
	rm -rf $(DOCS_OUTPUT)
	@echo "Cleaned $(DOCS_OUTPUT)"
