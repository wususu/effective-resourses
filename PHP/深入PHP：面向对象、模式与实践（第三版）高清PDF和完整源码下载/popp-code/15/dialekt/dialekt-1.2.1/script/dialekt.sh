#!/bin/sh

exec @php_bin@ -d include_dir=@php_dir@ @php_dir@/dialekt_cli.php "$@"
