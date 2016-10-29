# llum init command

This will configure init command using:

```bash
llum init
```

Llum will ask you some questions and save the answers to this question 
in ~/.llumrc file

# ~/.llumrc file

Format:

```bash
$ cat ~/.llumrc
; This is llum configuration file

[github]
username = acacha
token = TOKEN_HERE
```

Llum use [parse_ini_file](http://php.net/manual/en/function.parse-ini-file.php) to parse file.