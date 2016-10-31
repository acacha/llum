# llum github commands

# Authentication

Run: 

```bash
llum init
```

To execute llum init wizard. It will ask for data to Authenticate you 
at Github using API and basic authentication ([1](https://developer.github.com/v3/oauth_authorizations/#create-a-new-authorization))

Once user provides correct password this will create a personal token 
with name **llum_uuid** (where uuid is a unique identifier to avoid 
collisions). This token will be used by llum to execute other llum github 
commands without the need to provide credentials again.

You could see the new created token at:

https://github.com/settings/tokens

If you remove this token you will have to execute git init command again
before you can use other github commands.

The token will be stored in ~/.llumrc file. Example:

```bash
cat ~/.llumrc
; Llum configuration file

[github]
username = acacha
token = 751e11f7d04f789cd21a9132aad152c4c65b2de34
token_name = llum_58172ff62423
```

# github repo

The github repo commands will create a repo:

```bash
llum github repo [name]
```

name is optional (by default current folder name is used as repo name) 

Before you can execute this commands you have to authenticate yourself 
using llum github auth.


# github init

This will initialize a Github repo for current folder:

```bash
llum github init
```

These will execute the following steps:

- Initialize repo: git init command
- Add all files: git add .
- Create first commit: git commit -a -m "Initial revision"
- Create a github repo using **llum github repo** command
- Add origin repo: git remote add origin github_repo_url
- Sync local repo with github repo:  git pull origin master | git push origin master


