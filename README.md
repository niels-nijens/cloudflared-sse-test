# Cloudflared SSE test
This repository is created to test the behavior of a PHP-based Server-Sent Events stream
with the [Cloudflare Argo tunnel](https://developers.cloudflare.com/argo-tunnel/quickstart/).

## The problem
At the time of writing the cloudflared Argo tunnel does not seem to disconnect a SSE stream connection when the
browser disconnects and the proxy keeps the connection alive. This causes a PHP-FPM child process to be locked to a
disconnected stream as the PHP script never receives a disconnection through
[`connection_aborted()`](https://www.php.net/manual/en/function.connection-aborted).

When enough Server-Sent event stream requests are made to the PHP-FPM container, it will eventually only be processing
(disconnected) streams, causing a denial of service.

Server-Sent event stream requests sent directly to the Nginx container will stop processing properly when they are
disconnected. Freeing up the PHP-FPM process.

## Installation

### Prerequisites
To install this project you require the following tooling:
* [Git](https://git-scm.com/downloads)
* [Docker CE](https://docs.docker.com/install/)
* [Docker Compose](https://docs.docker.com/compose/install/)

Also, port 8090 is currently required to access the project through: [http://localhost:8090](http://localhost:8090)

### Get the source
Clone this repository to be able to use/test this project:
```bash
git clone https://github.com/niels-nijens/cloudflared-sse-test.git
```

## Usage
Start the project by executing the following command:
```bash
docker-compose up
```

This command will build and start an Nginx, PHP-FPM and Cloudflared container and show the container logs.
The cloudflared container will create a free Argo tunnel and display output similar to the following:
```bash
cloudflared_1_977caf5e35f8 | time="2020-01-22T13:12:27Z" level=info msg="Each HA connection's tunnel IDs: map[0:0765dtv5hkb3dle6bgtlb9hi0zl3vcv7367ydb4uga7f9i692kzg]" connectionID=0
cloudflared_1_977caf5e35f8 | time="2020-01-22T13:12:27Z" level=info msg=+-------------------------------------------------------------+ connectionID=0
cloudflared_1_977caf5e35f8 | time="2020-01-22T13:12:27Z" level=info msg="|  Your free tunnel has started! Visit it:                    |" connectionID=0
cloudflared_1_977caf5e35f8 | time="2020-01-22T13:12:27Z" level=info msg="|    https://elite-bread-accessible-rabbit.trycloudflare.com  |" connectionID=0
cloudflared_1_977caf5e35f8 | time="2020-01-22T13:12:27Z" level=info msg=+-------------------------------------------------------------+ connectionID=0
cloudflared_1_977caf5e35f8 | time="2020-01-22T13:12:27Z" level=info msg="Route propagating, it may take up to 1 minute for your new route to become functional" connectionID=0
```

This project will be accessible through the `Visit it:` Cloudflare URL.

### PHP-FPM status
To see the status of the (locked) PHP-FPM processes go to: [http://localhost:8090/status?html&full](http://localhost:8090/status?html&full)

## Resources

* [Server-Sent Events on MDN](https://developer.mozilla.org/en-US/docs/Web/API/Server-sent_events)
* [Cloudflare Argo tunnel documentation](https://developers.cloudflare.com/argo-tunnel/quickstart/)
* [Cloudflared repository on GitHub](https://github.com/cloudflare/cloudflared)
