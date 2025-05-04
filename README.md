<div align="center">
    <img src="./docs/img/logo.png" alt="Home Lab Logo" />
    <h1>
        Home Lab
    </h1>
</div>

Welcome to my homelab where I host useful services and websites. Previously I 
used Docker to run all the software but next realised that it uses too much
resources of the Raspberry Pi so instead of running Apache HTTP Server inside
the container decided to install the `apache2` service. This works much better. 

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

Or, it's better to execute [`apply.sh`](./ansible/apply.sh) as it also
automatically checks if all the necessary environment variables are set.

As a result, all the necessary services wil be automatically installed, all 
the required directories are created and the Pi is ready to go. 

## 💼 Services

### 📦 Core Services

Ansible automatically installes the following services: 

* Apache HTTP Server + PHP module
* MariaDB as a drop-in replacement for the MySQL
* phpMyAdmin for managing MariaDB databases
* Tomcat 10 + JDK 17 for running Java apps
* 🐞 Mantis Bugtracker [bt.abarmin.pro](https://bt.abarmin.pro)
* 👨‍💻 Personal website [abarmin.pro](https://abarmin.pro)

## 🤐 Secrets

To make the installation process working, it's necessary to add the Cloudflare
tunnel secret before executing the [`apply.sh`](./ansible/apply.sh) script. 

```shell
export TUNNEL_TOKEN="<Cloudflare Tunnel Token>"
```

## 🙋 How to 

Will write something when required...
