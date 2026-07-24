<?php
// DVWA secret and linting test case.
// This file intentionally contains common secret formats and unsafe code patterns.

// Dummy secrets that gitleaks built-in rules should detect.
$aws_access_key_id = 'AKIAIOSFODNN7EXAMPLE';
$aws_secret_access_key = 'wJalrXUtnFEMI/K7MDENG/bPxRfiCYEXAMPLEKEY';
$github_token = 'ghp_1234567890abcdefghijklmnopqrstuv';
$stripe_api_key = 'sk_live_123456789abcdefghi';
$db_password = 'SuperSecretPass123!';

// Unsafe code patterns for linting/security tools.
$command = $_GET['cmd'] ?? '';
eval($command);
system($command);
