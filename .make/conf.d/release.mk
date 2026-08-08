# Prepare a new release
# Update the graph of the models, translation files and the version in the package
.PHONY: prepare-release
prepare-release: pot
	@echo "Preparing a release…"
	@read -p "New Version Number: " new_version; \
	if ! grep -qE "^## \[$$new_version\]" CHANGELOG.md; then \
		previous_version=$$(grep -m 1 -E '^## \[[0-9]+(\.[0-9]+){0,3}\] - ' CHANGELOG.md | sed -E 's/^## \[([0-9]+(\.[0-9]+){0,3})\].*$$/\1/');  \
		echo "Previous release version detected: $$previous_version"; \
		echo "$(TEXT_COLOR_RED)$(TEXT_BOLD)Version $$new_version not found in CHANGELOG.md!$(TEXT_RESET)"; \
		echo "Adding a new section for version $$new_version."; \
		echo "Please check and update the $(TEXT_BOLD)CHANGELOG.md$(TEXT_RESET) file accordingly."; \
		sed -i "/<!-- Your changes go here -->/a\\\n## [$$new_version] - $$(date '+%Y-%m-%d')" CHANGELOG.md; \
		echo "[$$new_version]: $(GIT__GIT_REPOSITORY)/compare/v$$previous_version...v$$new_version \"v$$new_version\"" >> CHANGELOG.md; \
	fi; \
	sed -i -E "\|\"version\"\: |s|\"\: .*|\"\: \"$$new_version\",|g" package.json; \
	sed -i -E "\|\* Version\: |s|\: .*|\: $$new_version|g" style.css; \
	if [[ $$new_version =~ (alpha|beta) ]]; then \
		echo "$(TEXT_COLOR_RED)$(TEXT_BOLD)Pre-release$(TEXT_RESET) version detected!"; \
		git restore $(TRANSLATION__TEMPLATE); \
	elif [[ $$new_version =~ rc ]]; then \
		echo "$(TEXT_COLOR_YELLOW)$(TEXT_BOLD)Release Candidate$(TEXT_RESET) version detected!"; \
		sed -i "/\"Project-Id-Version: /c\\\"Project-Id-Version: $(GENERAL__NAME_VERBOSE) $$new_version\\\n\"" $(TRANSLATION__TEMPLATE); \
		sed -i "/\"Report-Msgid-Bugs-To: /c\\\"Report-Msgid-Bugs-To: $(GIT__GIT_REPOSITORY_ISSUES)\\\n\"" $(TRANSLATION__TEMPLATE); \
	else \
		echo "$(TEXT_BOLD)Release$(TEXT_BOLD_END) version detected."; \
		sed -i -E "\|\[in development\]\: |s|\]\: .*|\]\: $(GIT__GIT_REPOSITORY)/compare/v$$new_version...HEAD \"In Development\"|g" CHANGELOG.md; \
		sed -i "/\"Project-Id-Version: /c\\\"Project-Id-Version: $(GENERAL__NAME_VERBOSE) $$new_version\\\n\"" $(TRANSLATION__TEMPLATE); \
		sed -i "/\"Report-Msgid-Bugs-To: /c\\\"Report-Msgid-Bugs-To: $(GIT__GIT_REPOSITORY_ISSUES)\\\n\"" $(TRANSLATION__TEMPLATE); \
	fi;

# Create a new release archive
.PHONY: release-archive
release-archive:
	@echo "Creating a new release archive …"
	@rm -f $(TRANSLATION__TEXTDOMAIN).zip
	@rm -rf $(TRANSLATION__TEXTDOMAIN)/
	@rsync \
		-ax \
		--exclude-from=.make/rsync-exclude.lst \
		. \
		$(TRANSLATION__TEXTDOMAIN)/
	@zip \
		-r \
		$(TRANSLATION__TEXTDOMAIN).zip \
		$(TRANSLATION__TEXTDOMAIN)/
	@rm -rf $(TRANSLATION__TEXTDOMAIN)/

# Help message for the Release commands
.PHONY: help
help::
	@echo "  $(TEXT_UNDERLINE)Release:$(TEXT_UNDERLINE_END)"
	@echo "    prepare-release           Prepare a new release."
	@echo "    release-archive           Create a release archive."
	@echo "                              The release archive ($(TRANSLATION__TEXTDOMAIN).zip) will be created in the root"
	@echo "                              directory of the theme."
	@echo ""
