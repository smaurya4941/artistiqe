#!/bin/bash
# Run this ON THE LIVE SERVER (SSH) from the project root after deploying the cleaned code.
set -e
echo "== 1. Obfuscated backdoors (goto-chains) =="
grep -rlE "goto [A-Za-z0-9_]{4,};.{0,600}goto [A-Za-z0-9_]{4,};" --include="*.php" --include="*.blade.php" . 2>/dev/null | grep -v "/vendor/" || echo "  CLEAN"
echo "== 2. Code-exec primitives outside vendor =="
grep -rlE "\b(eval|assert|system|shell_exec|passthru|proc_open|popen)\s*\(|gzinflate\s*\(" --include="*.php" . 2>/dev/null | grep -v "/vendor/" || echo "  CLEAN"
echo "== 3. PHP files inside writable dirs (should be ONLY the .htaccess guards) =="
find public/uploads storage -iname "*.ph*" 2>/dev/null || echo "  CLEAN"
echo "== 4. Non-blade .php in resources/views =="
find resources/views -name "*.php" ! -name "*.blade.php" 2>/dev/null || echo "  CLEAN"
echo "== 5. World-writable files (0777/0666) =="
find . -not -path "./vendor/*" -type f -perm -o+w 2>/dev/null | head -20 || echo "  none"
echo "== 6. Files changed in last 30 days (review each) =="
find . -not -path "./vendor/*" -not -path "./storage/*" -not -path "./node_modules/*" -type f -mtime -30 2>/dev/null | head -60
echo "== 7. Known junk that must NOT exist =="
for f in defau1t.php public/defau1t.php public/test.php newfile backup.c error_log _ide_helper.php testdomain "resources/views/frontend/user/wallet/index.php"; do
  [ -e "$f" ] && echo "  STILL PRESENT: $f" || true
done
echo "  (no output above = good)"
echo "== 8. First line of front controller (must be '<?php' then 'use Illuminate...') =="
head -4 index.php
