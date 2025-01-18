<div align="center">
    <img src="./docs/img/logo.png" alt="Home Lab Logo" />
    <h1>
        Home Lab
    </h1>
</div>

Welcome to my homelab where I host useful services and websites. As the main 
compute engine I use Docker which uses all the power of the Raspberry Pi 4. 

## 🛠️ Installation

To make everything up and running you don't need to have a PhD in computer 
science, what you need is just a computer where Ansible will run and the 
Raspberry Pi which will run all the workloads. 

First of all, you need to install Ansible on the main computer, `brew` is a good
way to do so: 

```shell
brew install ansible
```

The next step is to generate the SSH key that will be used to access
the Raspberry Pi without need to enter the password: 

```shell
ssh-keygen -t rsa -b 4096 -C "Raspberry Pi"
```

When the key is generated, it is saved to the `~/.ssh/id_rsa` and needs to be
compied to the Raspberry Pi. Execute the following command to do so: 

```shell
ssh-copy-id abarmin@raspberrypi.local
```

You will be asked to enter the password for the user with name `abarmin`, 
ussing it exists. 

Execute the following command to test, you should be logged without in the need
to enter the password: 

```shell
ssh abarmin@raspberrypi.local
```

The next step is to make Ansible aware of the host and to do so it's necessary
to create an [`inventory.yml`](./ansible/inventory.yml) file which contains
all the details on how to connect to the Raspberry Pi: 

```yml
all:
  hosts:
    raspberrypi:
      ansible_host: raspberrypi.local
      ansible_user: abarmin
      ansible_ssh_private_key_file: ~/.ssh/id_rsa
```

Execute the following command to check the connection: 

```shell
ansible all -i ./ansible/inventory.yml -m ping
```

There should be no errors in the output. 

The last one step is to apply the [`playbook.yml`](./ansible/playbook.yml) that
installs Docker and copies `docker-compose.yml` files: 

```shell
ansible-playbook -i ./ansible/inventory.yml ./ansible/playbook.yml
```

As a result, the Docker should be automatically installed, all the required
directories are created and the Pi is ready to go. 

## 💼 Services

### 📦 Core Services

[`docker-compose.yml`](./docker/infra/docker-compose.yml)

* [Traefik](./docker/traefik/docker-compose.yml)
* [Glances](./docker/glances/docker-compose.yml)
* [Portainer](./docker/portainer/docker-compose.yml)
* [Homer](./docker/homer/docker-compose.yml)
* [Cloudflare Tunnel](./docker/cloudflared/docker-compose.yml)

### 🐞 Mantis Bugtracker [bt.abarmin.pro](https://bt.abarmin.pro)

[`docker-compose.yml`](./docker/bt.abarmin.pro/docker-compose.yml)

* MariaDB 10.6.20
* Apache HTTP + PHP 8.1

### ⏰ CronJobs

* [`publish-names.sh`](./docker/traefik/publish-names.sh)

## 🤐 Secrets

To make everything working, need to add the following to `.profile` in the home 
directory: 

```shell
export TUNNEL_TOKEN="<Cloudflare Tunnel Token>"
```

## 🙋 How to 

### 🆕 Add a new service

First, come up with the domain name and next update [`publish-name.sh`](./docker/infra/publish-names.sh)
script that publishes the domain name. 

Secondly, add the following `labels` to the `docker-compose.yml`: 

```yml
  my-service:
    labels:
      - "traefik.http.routers.my-service.rule=Host(`my-service.raspberrypi.local`)"
      - "traefik.http.routers.my-service.entrypoints=http"
      - "traefik.http.services.my-service.loadbalancer.server.port=61208"    
```

Finally, update the Homer [`config.yml`](./docker/infra/config/homer/config.yml)
by following the same approach as for other services. 

When changes are delivered to the Raspberry Pi, start/restart the docker, 
restart the `publish-name.sh` script. 

### 📝 Show memory consumption in `docker stats`

There is a topic on [stackoverflow](https://stackoverflow.com/a/77278502), but
long story short - add to `/boot/firmware/cmdlinetxt` the following: 

```
cgroup_enable=cpuset cgroup_enable=memory cgroup_memory=1
```
