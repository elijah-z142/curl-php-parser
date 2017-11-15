# curl-php-parser
POC parser for a php to curl converter


Created in relation to https://github.com/incarnate/curl-to-php/issues/1, on the curl-to-php repository, to create a php to curl reverse conversion.

This code uses the php-ast extension, and parses CURL function calls and constants into an array of objects, which can then be parsed to generate a CURL command line statement.

The object CurlCall has the function name, and a list of arguments in string/numeric/null format, where "null" is an element not parsed, and constants are stored as strings (same as URLs and other input strings, however they can be matched against a list of supported strings + argument indexes).

The parser is minimalistic and based on a few assumptions:
1) All code is in the top level scope
2) All constants are inlined as arguments, and so variable arguments to functions are trivial.
3) Each top level code line is either a curl function call or a function call assigned to a variable.

It should ignore other code types, but this is not tested (just a POC + needs more null checks).

example output:
```Function curl_init with args: http://www.example.com/
Function curl_setopt with args: {null}, CURLOPT_FILE, {null}
Function curl_setopt with args: {null}, CURLOPT_HEADER, 0
Function curl_exec with args: {null}
Function curl_close with args: {null}
Function fclose with args: {null}
```


Created in relation to https://github.com/incarnate/curl-to-php/issues/1, on the curl-to-php repository, to create a php to curl reverse conversion.

This code uses the php-ast extension, and parses CURL function calls and constants into an array of objects, which can then be parsed to generate a CURL command line statement.

The object CurlCall has the function name, and a list of arguments in string/numeric/null format, where "null" is an element not parsed, and constants are stored as strings (same as URLs and other input strings, however they can be matched against a list of supported strings + argument indexes).

The parser is minimalistic and based on a few assumptions:
1) All code is in the top level scope
2) All constants are inlined as arguments, and so variable arguments to functions are trivial.
3) Each top level code line is either a curl function call or a function call assigned to a variable.

It should ignore other code types, but this is not tested (just a POC + needs more null checks).

example output:
> Function curl_init with args: http://www.example.com/
> Function curl_setopt with args: {null}, CURLOPT_FILE, {null}
> Function curl_setopt with args: {null}, CURLOPT_HEADER, 0
> Function curl_exec with args: {null}
> Function curl_close with args: {null}
> Function fclose with args: {null}

License: MIT

For attribution:

[Runtime Converter (Online PHP to Java Converter)](http://www.runtimeconverter.com)

http://www.runtimeconverter.com
