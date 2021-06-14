# FirstPHPGraphQL

## GaphQL Shema

```graphql
type Query {
  echo(message: String!): String!
  sum(x: Int!, y: Int!): Int!
}
```

## Using

```
php -S localhost:8080 ./graphql.php
```

Open `http://localhost:8080/` at your browser and use.

## Example

```graphql
{
  echo(message: "Hello World")
  sum(x: 2 y:10)
  s2:sum(x: 2 y:1)
  s3:sum(x: 2 y:60)
  s4:sum(x: 2 y:50)
  s5:sum(x: 2 y:100)
}
```

## GraphQL Playground

Installing at arch: `yay graphql-playground-electron`

![](demo.png)

© Copyright Max Base, 2021
