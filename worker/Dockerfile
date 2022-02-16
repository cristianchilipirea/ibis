FROM ubuntu

RUN apt-get update && apt-get install -y \
	bc \
	gcc \
	make \
	openssh-server \
	psmisc \
	time \
	unzip \
	&& rm -rf /var/lib/apt/lists/*

RUN service ssh start

RUN useradd -rm -d /home/worker -s /bin/bash -g root -G sudo worker 

RUN  echo 'worker:worker' | chpasswd

EXPOSE 22

COPY key.pub /home/worker/.ssh/authorized_keys
RUN chown -R worker /home/worker/.ssh
RUN chmod 400 /home/worker/.ssh/authorized_keys
COPY sshd_config /etc/ssh/sshd_config

CMD ["/usr/sbin/sshd","-D"]