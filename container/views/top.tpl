{assign var="title" value="TOP"}
{extends file="layouts/application.tpl"}

{block name=body}
  <div>{$msg}</div>
  <form action="/create" method="post">
    <input type="text" name="user[name]">
  </form>
{/block}
