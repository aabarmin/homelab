# Homer Dashboard

The main idea is that the dasbhoard itself is static and no need to host it as
a dynamic webiste. The locally during development it's running in Docker and next
the static website is built and uploaded to the server. 

## Local development

Just run the `docker-compose.yml` by executing the following command: 

```sh
$ docker compose up
```

When started open [http://localhost:8080](http://localhost:8080). The config itself
is stored in the `./config` folder. 

## Building the static website

If you're building the Homer for the first time you need to build it. Make sure 
`pnpm` is installed before doing anything else. If not install using brew: 

```sh
$ brew install pnpm
```

The next step is just to run the `./build_static.sh` script:

```sh
$ ./build_static.sh
```

The script created the `./build` directory with the `./dist` folder inside and
copies the `config.yml` from the `./config` directory. Upload the content of
the `dist` folder to the server. 
