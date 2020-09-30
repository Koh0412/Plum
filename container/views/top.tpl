{assign var="title" value="TOP"}
{extends file="layouts/application.tpl"}

{block name=body}
  <div>{$msg}</div>
  <form action="/" method="post">
    <input type="text" name="user[name]">
  </form>
{/block}
