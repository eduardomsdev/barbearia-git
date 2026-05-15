<h1 align="center">✂️ Barbearia Git</h1>

<p align="center">
  Sistema web de agendamento de serviços para barbearia, com gestão de horários e listagem de clientes.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white" />
  <img src="https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white" />
  <img src="https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black" />
  <img src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white" />
  <img src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white" />
</p>

---

## Sobre o projeto

A **Barbearia Git** é uma aplicação web completa para gerenciamento de agendamentos de uma barbearia. O cliente acessa o site, escolhe um dos barbeiros disponíveis e preenche um formulário com seus dados e preferências. O sistema valida as informações, evita conflitos de horário e salva o agendamento no banco de dados.

---

## Funcionalidades

- **Vitrine de barbeiros** — cards com foto e descrição de cada profissional
- **Agendamento via modal** — sem redirecionamento de página, experiência fluida
- **Seleção de serviços** com tabela de preços
- **Geração automática de horários** disponíveis (08:00 às 17:30, a cada 30 min)
- **Validação dupla** — no front-end (JS) e no back-end (PHP)
- **Prevenção de conflito** — impede dois clientes no mesmo barbeiro/horário/data
- **Regras de negócio** — bloqueia fins de semana e datas passadas
- **Listagem de agendamentos** com agrupamento por barbeiro
- **Exclusão de agendamento** diretamente na listagem

---

## Serviços e preços

| Serviço             | Preço  |
|---------------------|--------|
| Social              | R$ 15  |
| Sobrancelha         | R$ 5   |
| Degradê             | R$ 20  |
| Cabelo e Barba      | R$ 30  |
| Degradê Navalhado   | R$ 30  |

---

## Tecnologias utilizadas

| Camada     | Tecnologia         |
|------------|--------------------|
| Front-end  | HTML5, CSS3, JavaScript (Vanilla) |
| Back-end   | PHP (MySQLi)       |
| Banco de dados | MySQL          |
| Servidor   | Apache / XAMPP     |

---

## Pré-requisitos

- [XAMPP](https://www.apachefriends.org/) (ou qualquer stack com Apache + PHP + MySQL)
- PHP 7.4+
- MySQL 5.7+

---

## Instalação e configuração

**1. Clone o repositório dentro da pasta do servidor**

```bash
git clone https://github.com/seu-usuario/barbearia-git.git
# ou mova a pasta para:
# Windows: C:/xampp/htdocs/barbearia-git
# Linux:   /var/www/html/barbearia-git
```

**2. Crie o banco de dados**

Acesse o phpMyAdmin ou seu cliente MySQL e execute:

```sql
CREATE DATABASE barbearia CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE barbearia;

CREATE TABLE agendamentos (
    id        INT AUTO_INCREMENT PRIMARY KEY,
    barbeiro  VARCHAR(100) NOT NULL,
    nome      VARCHAR(150) NOT NULL,
    gmail     VARCHAR(150) NOT NULL,
    data      DATE         NOT NULL,
    hora      VARCHAR(10)  NOT NULL,
    servico   VARCHAR(100) NOT NULL,
    observacao TEXT
);
```

**3. Configure a conexão**

Edite o arquivo [conexao.php](conexao.php) com as credenciais do seu ambiente:

```php
$servidor = "localhost";
$usuario  = "root";
$senha    = "";        // sua senha MySQL
$banco    = "barbearia";
```

**4. Inicie o servidor e acesse**

```
http://localhost/barbearia-git/
```

---

## Estrutura do projeto

```
barbearia-git/
├── index.html          # Página principal — vitrine e agendamento
├── cadastrar.php       # API de cadastro (recebe POST, retorna JSON)
├── listar.php          # Listagem de agendamentos (painel)
├── conexao.php         # Configuração da conexão com o banco
├── CSS/
│   ├── style.css       # Estilos da página principal
│   ├── listar.css      # Estilos da página de listagem
│   └── fundo_site.webp # Imagem de fundo
├── JS/
│   └── script.js       # Lógica do modal e envio via Fetch API
└── imagem/             # Fotos dos barbeiros e fundos dos modais
```

---

## Como usar

1. Acesse a página inicial e conheça os barbeiros disponíveis.
2. Clique em **Agendar Serviços** no card do barbeiro desejado.
3. No modal, preencha: nome, e-mail, data, horário, serviço e observação.
4. Clique em **Finalizar** — o sistema valida os dados e confirma o agendamento.
5. Para ver todos os agendamentos, acesse `listar.php`.

---

## Regras de agendamento

- Apenas **datas futuras** são aceitas
- A barbearia **não funciona aos sábados e domingos**
- Não é possível agendar um **horário já ocupado** com o mesmo barbeiro
- Todos os campos são **obrigatórios**

---

## Licença

Distribuído sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.

---

<p align="center">Feito por <a href="https://github.com/eduardomsdev">Eduardo Martins</a></p>
