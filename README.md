# AWS S3 Helper

Proof of concept of an AWS S3 plugin that supports restricted buckets.

This plugin is not supported and will likely be rolled into a pull request for the AWS S3 plugin if we get around to it.

## Installation

As this is not a published plugin, you'll need to add this repo to your `composer.json` repositories array:

``` json
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/barrelstrength/craft-aws-s3-helper"
    }
  ]
```

Then, require the [AWS S3 Plugin](https://github.com/craftcms/aws-s3) and this plugin:

```
composer require craftcms/aws-s3 ^1.0.0
composer require barrelstrength/aws-s3-helper
```