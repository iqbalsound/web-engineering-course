# Week 16 solutions: Containerised Capstone and Revision

## Expected results and evidence
| Check | Expected result / model evidence |
| --- | --- |
| `podman info --format …` | Rocky: `rootless=true selinux=true`; Kubuntu: `rootless=true` |
| `podman-compose ps` | Services `db` (healthy) and `web` (running); `web` publishes `127.0.0.1:8090->80` |
| `curl http://127.0.0.1:8090/` | “DB OK – 8 products” and the PHP version |
| `podman-compose stop db` then request | HTTP 503 with “DB unavailable”; back to 200 after `start db` |
| `down` then `up` | Still 8 products – data kept in volume `dbdata` |
| `systemctl --user status mailpit.service` | `active (running)`; UI returns 200 on 8025 |
| Syntax error commit | Hook prints the parse error and the commit is aborted |
| `git tag` | `v1.0.0` |

**Typical ps output**

```
CONTAINER ID  IMAGE                               STATUS                  PORTS
a1b2c3d4e5f6  docker.io/library/mariadb:lts       Up 2 minutes (healthy)
b2c3d4e5f6a7  localhost/capstone_web:latest       Up 2 minutes            127.0.0.1:8090->80/tcp
```


## Troubleshooting guide
| Symptom | Likely cause | Fix (Rocky 10 / Kubuntu 26.04) |
| --- | --- | --- |
| Mount error / “MOUNT_OPTS” empty | `.env` not in the project folder | Create `.env` next to `compose.yaml` (`ro,Z` on Rocky, `ro` on Kubuntu) |
| Apache in the container: 403 / permission denied (Rocky) | Missing `Z` relabel on the bind mount | Use `ro,Z`; check `ausearch -m avc -ts recent` |
| Database starts but tables missing | Init scripts run only on an empty volume | `podman-compose down -v` (deletes data) and start again |
| `web` starts before DB is ready | Healthcheck not honoured by compose provider | Retry loop in app; upgrade `podman-compose`; check `depends_on` syntax |
| Port 8090 or 8025 busy | Old container or service | `ss -tlnp \| grep -E "8090\|8025"`; `podman rm -f mailpit` before starting the Quadlet |
| `short-name resolution` errors | Unqualified image name | Use fully qualified `docker.io/...` names (as supplied) |
| Quadlet service not found | Unit file in wrong folder or no reload | File in `~/.config/containers/systemd/`; run `systemctl --user daemon-reload` |
| `podman-compose: command not found` (Rocky) | EPEL package not available | `pip install --user podman-compose` and add `~/.local/bin` to PATH |

## Viva prompts and marking notes
- Ask the student to explain why the database is reachable from `web` as host `db` but not from the LAN.
- Ask what `:Z` does and why it is unnecessary on Kubuntu.
- Marking points: stack runs (3), persistence/recovery evidence (2), Quadlet service (2), Git hygiene + hook (2), viva (1).

## Answers to review questions
1. An image is a read-only layered template; a container is a running instance of it (a process with isolation); a volume is storage that outlives containers.
2. Binding to `127.0.0.1` keeps development services (databases, admin tools) off the LAN, where a weak password could be attacked.
3. Injection → prepared statements. XSS → output escaping `e()`. Broken access control → role checks and files outside the web root. Cryptographic failures → HTTPS and `password_hash`. CSRF / authentication failures → tokens and `session_regenerate_id`.
4. 2-tier: client talks directly to the database server, simple but exposes data. 3-tier: presentation, application and data tiers, scalable and safer. MVC: a code pattern inside the application tier that separates data, output and request handling.
5. Example: Laravel or CodeIgniter 4 for custom registration rules, payments and reporting (criteria: custom workflow, validation/auth, team skills). WordPress is acceptable only for a simple informational site with a registration plugin.
