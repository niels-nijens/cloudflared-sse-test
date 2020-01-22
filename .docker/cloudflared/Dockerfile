# Based on: https://github.com/cloudflare/cloudflared/blob/7367827a1117932e0fbea37594b136ae4bf0ba33/Dockerfile

# use a builder image for building cloudflare
FROM golang:1.13.3 as builder
ENV GO111MODULE=on
ENV CGO_ENABLED=0
ENV GOOS=linux
ENV CLOUDFLARED_TAG=2019.12.0

WORKDIR /go/src/github.com/cloudflare/cloudflared/

# Clone cloudflared source into the builder image.
RUN git clone -b $CLOUDFLARED_TAG --single-branch https://github.com/cloudflare/cloudflared.git .

# compile cloudflared
RUN make cloudflared

# Create empty configuration file.
RUN touch config.yaml

# ---

# use a distroless base image with glibc
FROM gcr.io/distroless/base-debian10:nonroot

# copy our compiled binary
COPY --from=builder --chown=nonroot /go/src/github.com/cloudflare/cloudflared/cloudflared /usr/local/bin/

# Copy empty configuration file.
COPY --from=builder --chown=nonroot /go/src/github.com/cloudflare/cloudflared/config.yaml /usr/local/etc/cloudflared/config.yaml

# run as non-privileged user
USER nonroot

# command / entrypoint of container
ENTRYPOINT ["cloudflared", "--no-autoupdate"]
CMD ["version"]
