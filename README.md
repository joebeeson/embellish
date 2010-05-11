# Embellish Plugin for CakePHP 1.3+

Embellish plugin provides an easy way to parse various formatting languages into HTML

## Supported formats

* BBCode
* Markdown
* Textile

## Installation

* Download the plugin

        $ cd /path/to/your/app/plugins && git clone git://github.com/joebeeson/embellish.git

* Add the `TongueHelper` to your `AppController`

        public $helpers = array(
            // Replace 'Syntax' with your preferred format
            'Embellish.Tongue' => 'Syntax'
        );

## Usage

To parse a string into its HTML version, simply call the `TongueHelper`'s `toHtml` method.

        echo $this->Tongue->toHtml('This is [b]BBCode[/b]!');

You can also change syntaxes "on the fly" by using the `setSyntax` method

        $this->Tongue->setSyntax('Markdown');
        echo $this->Tongue->toHtml('This is *Markdown*!');

## Thanks

The actual parsing of the formatting was achieved by using open source implementations. Many thanks are owed to the following developers...

* [Michel Fortin][1] for his [PHP Markdown][2] library
* Dean Allen, Carlo Zottmann and Alex Shiels for their [Textile][3] library

  [1]: http://michelf.com/
  [2]: http://michelf.com/projects/php-markdown/
  [3]: http://textile.thresholdstate.com/
