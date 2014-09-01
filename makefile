sync-db:
	/usr/local/php/bin/php vendor/bin/doctrine orm:schema-tool:update --force --dump-sql

drop-db:
	/usr/local/php/bin/php vendor/bin/doctrine orm:schema-tool:drop --force
