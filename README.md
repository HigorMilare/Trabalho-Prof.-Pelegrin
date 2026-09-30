# Sistema de Gestão de Produtos e Cesta de Compras

> Trabalho Académico de Gestão e Desenvolvimento Web.
> Professor: Carlos Eduardo Simões Pelegrin

---

## 👥 Integrantes da Equipe
- **Higor Henrique Milaré de Oliveira** - RA: 60009484


---

## 📋 Descrição do Projeto
Este sistema é uma aplicação web desenvolvida em PHP e MySQL para a gestão de fornecedores, produtos e cestas de compras de usuário. Estruturado e baseado nas informacões cedidas pelo professor em sala, para executar o trabalho.

---

## 🛠️ Tecnologias Utilizadas
- **Front-end:** HTML, CSS, Bootstrap 5, JavaScript (AJAX / Fetch API)
- **Back-end:** PHP 8.x
- **Banco de Dados:** MySQL
- **Servidor Local:** XAMPP / Apache

---

## 📁 Estrutura de Ficheiros do Projeto

- `Tela_Login.php` - Tela de autenticação de usuários.
- `Cad_Usuario.php` - Formulário de registo de novos Usuários.
- `Cad_Produto.php` - Painel de gestão de fornecedores e produtos (com atualização AJAX).
- `Area_Produto.php` - Area para seleção de produtos com seleção via checkbox.
- `Carrinho.php` - Resumo do carrinho com cálculo do valor total.
- `API.php` - Processamento de dados, inserção e respostas JSON.
- `db.php` - Conexão ao banco de dados e criação automática de tabelas.
- `Logout.php` - Encerramento de sessão.

---

## 🎨 Protótipos das Telas (Figma / UX)

### Tela de Login:
![Tela de Login](C:\xampp\htdocs\meu_projeto\Telas.figma\TelaLogin.png)


---

## 🚀 Como Executar o Projeto

1. Instale e inicie o **XAMPP** (serviços Apache e MySQL ativos).

2. Coloque a pasta do projeto dentro do diretório `htdocs` do XAMPP
   `C:/xampp/htdocs/meu_projeto/`
   
3. Abra o navegador e aceda ao endereço:
   `http://localhost/meu_projeto/Tela_Login.php`
4. A base de dados e as tabelas serão criadas automaticamente ao iniciar a aplicação pela primeira vez. 

   Lembrando que para executar de forma correta o banco de dados, tem que ser executado o passo a passo
   de instalação, iniciação e execução de forma correta!

## **Acessar a Aplicação:**
   - Abra o seu navegador e acesse a URL:
     `http://localhost/meu_projeto/Tela_Login.php`

---

## 🧪 Fluxo de Teste Recomendado

Para testar o funcionamento completo da aplicação:

1. **Cadastro de Usuário:** Acesse `Cad_Usuario.php`, crie uma conta e faça o login em `Tela_Login.php`.

2. **Cadastro de Dados:** Acesse a tela `Cad_Produto.php` para cadastrar um Fornecedor e, em seguida, um Produto associado a ele.

3. **Atualização AJAX:** Na própria tela `Cad_Produto.php`, clique no botão *"Clique para atualizar!"* para testar a busca de dados em tempo real via API.

4. **Seleção de Produtos:** Vá para `Area_Produto.php`, selecione um ou mais produtos utilizando os checkboxes e clique em *"Adicionar Selecionados à Cesta"*.

5. **Gerenciamento do Carrinho:** Acesse `Carrinho.php` para visualizar os itens cadastrados, a contagem total, o valor somado e o botão para remover itens.

6. **Logout:** Clique em *"Sair"* no menu para encerrar a sessão com segurança em `Logout.php`.


## 🗄️ Modelagem de Dados (DER)

```mermaid
erDiagram
    USUARIOS {
        int id PK
        string nome
        string email
        string senha
    }

    FORNECEDORES {
        int id PK
        string nome
        string cnpj
    }

    PRODUTOS {
        int id PK
        string nome
        decimal preco
        int fornecedor_id FK
    }

    CESTAS {
        int id PK
        int usuario_id FK
        int produto_id FK
    }

    USUARIOS ||--o{ CESTAS : "possui"
    FORNECEDORES ||--o{ PRODUTOS : "fornece"
    PRODUTOS ||--o{ CESTAS : "esta_incluido_em"
