{assign var="title" value="TOP"}
{extends file="layouts/application.tpl"}

{block name=body}
  <div>{$msg}</div>
  <form action="/" method="post">
    <div>
      <input type="text" name="name">
    </div>
    <div><input type="submit" value="send"></div>
  </form>
{/block}
