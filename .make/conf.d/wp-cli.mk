# Variables for the WordPress CLI and the path to the WordPress installation
wp_cli = vendor/bin/wp
wp_path = ./../../../../WP-Sources

# Activate the theme
.PHONY: activate-theme
activate-theme:
	@$(wp_cli) theme activate \
		$(GENERAL__NAME_VERBOSE) \
		--path=$(wp_path)

# Clear all transient caches from the WordPress database
.PHONY: clear-transient
clear-transient:
	@echo "Clearing all transient caches from the WordPress database …"
	@$(wp_cli) transient delete \
		--all \
		--path=$(wp_path)

# Deactivate the theme
.PHONY: deactivate-theme
deactivate-theme:
	@$(wp_cli) theme deactivate \
		$(GENERAL__NAME_VERBOSE) \
		--path=$(wp_path)

# Create the theme .pot file
.PHONY: pot
pot:
	@$(wp_cli) i18n make-pot \
		. \
		l10n/$(TRANSLATION__TEXTDOMAIN).pot \
		--slug=$(TRANSLATION__TEXTDOMAIN) \
		--domain=$(TRANSLATION__TEXTDOMAIN) \
		--headers='{"Report-Msgid-Bugs-To":"$(GIT__GIT_REPOSITORY_ISSUES)"}' \
		--include="/"

# Start the WP-CLI shell
.PHONY: shell
shell:
	@echo "Starting the WP-CLI shell …"
	@$(wp_cli) shell \
		--path=$(wp_path)

# Help message for the WP-CLI commands
.PHONY: help
help::
	@echo "  $(TEXT_UNDERLINE)WP-CLI:$(TEXT_UNDERLINE_END)"
	@echo "    activate-theme            Activate the theme."
	@echo "    clear-transient           Clear all transient caches from the WordPress database."
	@echo "    deactivate-theme          Deactivate the theme."
	@echo "    pot                       Create the theme .pot file."
	@echo "    shell                     Start the WP-CLI shell."
	@echo ""
