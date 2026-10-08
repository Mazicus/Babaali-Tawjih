<?php
declare(strict_types=1);
require __DIR__ . '/../config/google.php';

function rejects(callable $test): void
{
    try { $test(); } catch (RuntimeException $error) { return; }
    throw new RuntimeException('Expected rejection.');
}
$state = ['state' => 'known-state', 'created_at' => time()];
validateGoogleState($state, 'known-state');
rejects(fn() => validateGoogleState($state, 'wrong-state'));
rejects(fn() => validateGoogleState($state, ['known-state']));
rejects(fn() => validateGoogleState(['state' => 'known-state', 'created_at' => time() - 601], 'known-state'));
$profile = ['sub' => '123', 'email' => 'Person@example.com', 'email_verified' => true, 'name' => 'Person'];
if (googleIdentity($profile)['email'] !== 'person@example.com') { throw new RuntimeException('Email normalization failed.'); }
rejects(fn() => googleIdentity(array_replace($profile, ['email_verified' => false])));
rejects(fn() => googleIdentity(array_replace($profile, ['email_verified' => 'true'])));
rejects(fn() => googleIdentity(array_replace($profile, ['sub' => ''])));
rejects(fn() => googleIdentity(array_replace($profile, ['email' => 'invalid'])));
putenv('GOOGLE_CLIENT_ID=test');
putenv('GOOGLE_CLIENT_SECRET=test');
putenv('GOOGLE_REDIRECT_URI=https://example.com/google-callback.php');
googleConfiguration();
putenv('GOOGLE_REDIRECT_URI=http://example.com/google-callback.php');
rejects(fn() => googleConfiguration());
putenv('GOOGLE_REDIRECT_URI=http://localhost:8000/google-callback.php');
googleConfiguration();
putenv('GOOGLE_REDIRECT_URI=https://example.com/wrong.php');
rejects(fn() => googleConfiguration());
putenv('GOOGLE_CLIENT_SECRET=');
rejects(fn() => googleConfiguration());
echo "Google OAuth validation checks passed.\n";
