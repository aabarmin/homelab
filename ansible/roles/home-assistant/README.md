## Home Assistant Installation

Okay, it wasn't easy to configure all the parts of the Home Assistant,
I followed the following guides:

* [Reverse Proxy](https://community.home-assistant.io/t/reverse-proxy-with-apache/196942)
* [HTTP Configuration](https://www.home-assistant.io/integrations/http/)
* [400 Bad Request behind reverse proxy](https://community.home-assistant.io/t/home-assistant-400-bad-request-docker-proxy-solution/322163)

Add the following to the `configuration.yml`:

```yaml
http:
  use_x_forwarded_for: true
  trusted_proxies:
    - 10.0.0.0/8
```