# Changelog

All notable changes to Laravel Claude Chat will be documented in this file.

## 0.1.0 - 2024-03-15

### Added
- Initial release of the Laravel Claude Chat package 🎉
- `ClaudeChat` class for sending requests to the Claude API
- `create` method for sending custom requests to the Claude API
- `createJson` method for retrieving JSON responses from the Claude API
- `ClaudeChatServiceProvider` for registering the package with Laravel
- `ClaudeModels` class for storing constant values of Claude models
- `ClaudeChat` facade for convenient access to the `ClaudeChat` class
- Configuration file for setting the Claude API key, endpoint, request timeout, and retry parameters
