
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CSS Grid Layout</title>

</head>
<body>
  <main>
    <header>Header</header>
    <article>Content</article>
      <?php include_once 'components/sideBar.php'; ?>
    <?php include_once 'components/footer.php'; ?>
  </main>
</body>


<style>
    * {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
  border: dashed 1px black;
}

body {
  font-family: Arial, sans-serif;
}

main {
  display: grid;
  grid-template-areas:
    "head head"
    "side content"
    "foot foot";
  grid-template-rows: 50px auto 50px;
  grid-template-columns: 1fr 2fr;
  gap: 10px;
  padding: 10px;
  height: 100vh;
}

header {
  grid-area: head;
  background-color: orange;
  display: flex;
  justify-content: center;
  align-items: center;
  font-weight: bold;
}

article {
  grid-area: content;
  background-color: deepskyblue;
  display: flex;
  justify-content: center;
  align-items: center;
}

aside {
  grid-area: side;
  background-color: dodgerblue;
  display: flex;
  justify-content: center;
  align-items: center;
}

footer {
  grid-area: foot;
  display: flex;
  justify-content: center;
  align-items: center;
  font-weight: bold;
    background: #111;
    color: white;
    padding: 20px 40px;
    text-align: center;
}

</style>