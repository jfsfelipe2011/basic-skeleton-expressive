# Basic Skeleton Zend Expressive 3

Esse projeto compreende uma API, que foi desenvolvida com o microframework
[zend-expressive](https://docs.zendframework.com/zend-expressive/) e tem uma estrutura
que favorece o uso das PSR's [15](https://www.php-fig.org/psr/psr-15/) e [17](https://www.php-fig.org/psr/psr-17/).

#### Como rodar o projeto?

O projeto usa como ambiente de desenvolvimento containers [docker](https://www.docker.com/). Para subir o container é necessário ter instalado em seu computador a biblioteca [docker-compose](https://docs.docker.com/compose/).
Também recomendo o uso do container [docker-hosts-updater](https://github.com/grachevko/docker-hosts-updater). Caso não use o updater você terá que mapear
o IP do container no hosts de seu computador.

Abaixo seguem os passos para rodar o container do projeto:

- Primeiro você deve criar a rede do container ou alterar o arquivo
```docker-compose.yml``` para uma já existente. Caso não tenha nenhuma rede
execute o seguinte comando:

```shell
docker network create jose
```

- Depois de criar a rede, dê permissão de execução ao arquivo de inicialização com o comando:

```shell
chmod +x startapp.sh
```

- Com a devida permissão é necessário rodar o arquivo de inicialização:

```shell
./startapp.sh
```

- O arquivo irá fazer o build e download das images necessária para o container.
Depois de terminar o build e os comandos necessários, o container do composer ainda
irá estar rodando e criando a pasta vendor. Por isso verifique a finalização da instalação das bibliotecas
com o seguinte comando, antes de prosseguir:

```shell
docker logs -f basic-expressive-composer
```

- Depois de instaladas as bibliotecas acesse o container criado com o segunite comando:

```shell
docker exec -it basic-expressive-web sh
```

- Dentro do container execute os comandos para a migração de dados e a aplicação estará pronta para teste.

```shell
vendor/bin/phinx migrate
vendor/bin/phinx seed:run
```