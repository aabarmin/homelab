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
copied to the Raspberry Pi. Execute the following command to do so: 

```shell
ssh-copy-id abarmin@barmin-home.local
```

You will be asked to enter the password for the user with name `abarmin`, 
ussing it exists. 

Execute the following command to test, you should be logged without in the need
to enter the password: 

```shell
ssh abarmin@barmin-home.local
```

The next step is to make Ansible aware of the host and to do so it's necessary
to create an [`inventory.yml`](./ansible/inventory.yml) file which contains
all the details on how to connect to the Raspberry Pi: 

```yml
all:
  hosts:
    raspberrypi:
      ansible_host: barmin-home.local
      ansible_user: abarmin
      ansible_ssh_private_key_file: ~/.ssh/id_rsa
```

Execute the following command to check the connection: 

```shell
ansible all -i ./ansible/inventory.yml -m ping
```

There should be no errors in the output. 

The last one step is to apply the [`playbook.yml`](./ansible/playbook.yml) that
installs all the necessary software.

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
* 📚 Nextcloud [hub.barmin-home.local](http://hub.barmin-home.local)
* 🐞 Mantis Bugtracker [bt.abarmin.pro](https://bt.abarmin.pro)
* 👨‍💻 Personal website [abarmin.pro](https://old.abarmin.pro)

## 🤐 Secrets

To make the installation process working, it's necessary to add the Cloudflare
tunnel secret before executing the [`apply.sh`](./ansible/apply.sh) script. 

```shell
export CLOUDFLARE_TOKEN="<Cloudflare Tunnel Token>"
```

## 🙋 How to 

## Add HEIC support to NextCloud

1. Make sure ImageMagick extension is installed (should be installed automatically) 
  by Ansible but just in case you're doing the installation manually. 
2. Add the following lines to the `config/config.php` file: 

```php
  'enabledPreviewProviders' =>
    array (
      0 => 'OC\\Preview\\BMP',
      1 => 'OC\\Preview\\GIF',
      2 => 'OC\\Preview\\JPEG',
      3 => 'OC\\Preview\\Krita',
      4 => 'OC\\Preview\\MarkDown',
      5 => 'OC\\Preview\\MP3',
      6 => 'OC\\Preview\\OpenDocument',
      7 => 'OC\\Preview\\PNG',
      8 => 'OC\\Preview\\TXT',
      9 => 'OC\\Preview\\XBitmap',
      10 => 'OC\\Preview\\HEIC',
      11 => 'OC\\Preview\\Movie',
    ),
```

## Register manually uploaded files to NextCloud

It's much quicker to upload files by using SFTP rather than NextCloud's WebDav. 
But the files loaded manually will not appear on NextCloud because it's necessary
to register them first. Can be done by scanning: 

```shell
sudo -u www-data php occ files:scan --all
```

Will take some time but next these files will appear in the UI too. 

## Group preview generation

After uploading of multiple files it's better to generate previews for all of them. 
To do so need to install `Preview Generator` app and execute: 

```shell
sudo -u www-data php occ preview:generate-all
```

It'll take some time but the progress will be shown in the terminal. 

## Use Imeginary to generate previews for various image types

Recently added the `golang` and `imaginary` roles. The first one installs
the `go` executable, the second one installs a high-performance image library
[imaginary](https://github.com/h2non/imaginary). The library provides with 
a service that listens to `28080` port and converts images. 

To use it add the following line to the `nextcloud/config/config.php`:

```
'preview_imaginary_url' => 'http://localhost:28088/',
```

And enable a corresponding preview provider: 

```php
 'enabledPreviewProviders' => array(
  ..
  12 => 'OC\\Preview\\Imaginary'
 )
```
