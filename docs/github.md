# llum github commands

# github auth

Authenticate user at Github using API and basic authentication ([1](https://developer.github.com/v3/oauth_authorizations/#create-a-new-authorization))

```bash
llum github auth [username]
```

Once user provides correct password this will create a personal token 
with name **llum**. This token will be used by llum to execute other 
llum github commands without the need to provide credentials again.

username is optional (by default we will use current unix username or 
pre-configured llum username see llum init command)

You could see the new created token at:

https://github.com/settings/tokens

If you remove this token you will have to execute llum auth command again
before you can use other commands.

The token will be stored in ~/.llumrc file.

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


