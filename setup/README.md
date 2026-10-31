# Lab 0 – Common lab environment

Run **once** before Week 1. Both scripts build the same base: patched OS, Apache with the virtual host `webeng.test`
(document root `/var/www/webeng`), Git, Node.js LTS (nvm), Firefox and VSCodium.

| OS | Script | Notes |
| --- | --- | --- |
| Rocky Linux 10 | [`rocky10/lab0.sh`](rocky10/lab0.sh) | Needs an x86-64-v3 CPU (AVX2). SELinux stays **enforcing**. |
| Kubuntu 26.04 LTS | [`kubuntu2604/lab0.sh`](kubuntu2604/lab0.sh) | Configures `ufw` and the Apache site `webeng`. |

> The scripts are an assembled, readable version of the manual's steps. Read them before running, and rehearse on a
> disposable VM first. After the script: `curl -i http://webeng.test/` must return `HTTP/1.1 200 OK`.
