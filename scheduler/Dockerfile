FROM bash:4.4

RUN apk add --no-cache \
	openssh-client \
	unzip

RUN mkdir -p /home/data/uploads && \
	mkdir -p /home/data/buffer && \
	mkdir -p /home/data/rezults && \
	mkdir -p /home/data/checker

WORKDIR /home
COPY src /home

CMD ["bash", "/home/moveToBufferDaemon.sh"]