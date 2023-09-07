A really basic implementation of 
https://wiki.php.net/rfc/pipe-operator

Quick start:

1. add repository to composer.json
```
"repositories": [
  {
    "type": "git",
    "url": "git@github.com:emycakes/pipe-operator.git"
  }
]
```

2. use it
```
echo pipe('Hello World')
    ->str_split()
    ->array_reverse()
    ->implode('');
```
