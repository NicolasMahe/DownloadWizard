DownloadWizard
==============

A wizard made for helping you in every day downloads.

This repostory is discarded.

# Installation

Copy `backend/config.model.json` to `backend/config.json` and set your config.

Add to a cron service :

```
crontab -e
```

```
*/30 * * * * curl --user Me:purple  http://w.caprica.mahe.me/backend/?page=cron'&'action=doit
```
