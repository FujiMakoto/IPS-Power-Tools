# Power Tools

## Introduction
Power Tools is a third party command line utility for Invision Power Suite developers. It aims to aid in development by packaging several useful command line script and applications together in one easy to use application.

## Installation
If you are on Linux, there is an optional executable included in the release package which you can extract and copy to **/usr/local/bin** for convenience.

Otherwise, just extract the included ptools.phar file to the directory of your IPS installation. Then, from your terminal window, navigate to the applications directory and run ptools.phar as you would any other PHP script from the command line,

```
$ php ptools.phar 
Power Tools version 0.1

Usage:
  command [options] [arguments]

Options:
  -h, --help            Display this help message
  -q, --quiet           Do not output any message
  -V, --version         Display this application version
      --ansi            Force ANSI output
      --no-ansi         Disable ANSI output
  -n, --no-interaction  Do not ask any interactive question
  -v|vv|vvv, --verbose  Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug

Available commands:
  classmap     Generate a map of error codes for classes in an IPS application
  help         Displays help for a command
  list         Lists commands
  tinker       Launches an interactive shell interpreter for an IPS installation
 proxy
  proxy:regen  (Re)generates all proxy classes for the application
```

## Features

### Tinker
Tinker is one of Power Tools most.. well, *powerful* features! The name tinker was inspired by Laravel's own "tinker" command, and it essentially operates in the same manner.

Both are powered by [PsySH](http://psysh.org), an application that provides an extremely powerful PHP REPL for your applications.

Stop making your life difficult by executing arbitrary code in random modules for testing, or worse yet, actually trying to use the native PHP CLI interpreter.

Need to test if your Item class is working correctly? Just pop into the REPL and give it a whirl!
![Tinker - Item Class](https://i.imgur.com/5HppaWp.png)

Everything in the tinker shell essentially works as your application does when run through the web browser. You can even get documentation on class methods right from within the interpreter,
![Tinker - Documentation](https://i.imgur.com/nvWH9kQ.png)

PsySh is a truly awesome tool. To learn more about it and all the features it offers you, check it out on [PsySh.org](http://psysh.org).

### Proxy Classes
Due to the nature of the IPS 4.x framework, several useful features of your IDE may become non-functional (suggestions, code completion, etc). This command will generate proxy classes for IPS (including 3rd-party applications), so your IDE will know how to use IPS style classes.

This command was based off of [CodingJungle](https://community.invisionpower.com/profile/355173-codingjungle/)'s own [Proxy Class Generator script](https://community.invisionpower.com/files/file/7394-proxy-class-generator/).

![Proxy Class Generator](https://i.imgur.com/0zTuJ2S.png)

### Class Mapping

The classmap command maps unique ID numbers to your applications class files. These ID numbers are then stored and maintained for use in error codes.

By maintaining and actively using a proper error code scheme, you can easily and transparently map the location of errors that are triggered in production.

For more information on this feature, refer to the original [Classmap](https://community.invisionpower.com/files/file/7795-classmap-error-code-generator/) script.

![Class Mapping](https://i.imgur.com/GBHT1oj.png)

## License
```
The MIT License (MIT)

Copyright (c) 2015 Makoto Fujimoto

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
```
