# This file contains development-specific make targets for the Terra Nanotech WordPress theme.

# Sync the theme to the live server using rsync
.PHONY: sync-to-live
sync-to-live:
	@rsync \
		--archive \
		--verbose \
		--compress \
		--human-readable \
		--progress \
		--info=progress2 \
		--delete \
		--exclude-from=".make/rsync-exclude.lst" \
		--cvs-exclude \
		--delete-excluded \
		-e "ssh -p $(LIVE_SERVER__SSH_PORT)" \
		. \
		$(LIVE_SERVER__SSH_USER)@$(LIVE_SERVER__HOST):$(LIVE_SERVER__WEBROOT)$(LIVE_SERVER__THEME_DIRECTORY)

# Sync the theme to the live server using rsync in dry-run mode (no actual changes made)
.PHONY: sync-to-live-dry-run
sync-to-live-dry-run:
	@rsync \
		--archive \
		--verbose \
		--compress \
		--human-readable \
		--progress \
		--info=progress2 \
		--delete \
		--exclude-from=".make/rsync-exclude.lst" \
		--cvs-exclude \
		--delete-excluded \
		--dry-run \
		-e "ssh -p $(LIVE_SERVER__SSH_PORT)" \
		. \
		$(LIVE_SERVER__SSH_USER)@$(LIVE_SERVER__HOST):$(LIVE_SERVER__WEBROOT)$(LIVE_SERVER__THEME_DIRECTORY)

help::
	@echo "  $(TEXT_UNDERLINE)Development:$(TEXT_UNDERLINE_END)"
	@echo "    sync-to-live                Sync the theme to the live server using rsync"
	@echo "    sync-to-live-dry-run        Sync the theme to the live server using rsync in dry-run mode (no actual changes made)"
	@echo ""
