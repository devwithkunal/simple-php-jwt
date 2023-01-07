# Simple PHP JWT `v1.0`

This is a simple PHP JWT Class. It requires no dependencies. Fork it and have fun with it.

It's a standalone single file PHP class to use on your projects. It requires no dependencies or no framework.

## How to use

You only need one file:

- `Token.php`

This is the class you need to generate & verify web token

### Generate Token
```php
const KEY = 'thisisakey';

$token = Token::Sign(['id' => 'demo-id'], KEY, 60*5);
```
First argument is the `payload`, second is the `signature key` and third (optonal) is the `max age` in seconds.

Return will be a `token` as string

### Verify Token
```php
$payload = Token::Verify($token, KEY);
```
First argument is the `token` as string and second is the `signature key`.

Return will be a boolen `false` value if token is invalid or expired, else it will return the `payload`.

## About
This code uses `base64_encode` to encode strings and `HS256` for signature algorithm.

You can change it on `Token.php` file at line `28`.