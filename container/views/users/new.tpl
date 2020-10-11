{assign var="title" value="new"}
{extends file="layouts/application.tpl"}

{block name=body}
  <h4>create user</h4>
  <form action={route path="users"} method="post">
    <div>
      <input type="text" name="name">
    </div>
    <div>
      <input type="number" name="age">
    </div>
    <div><input type="submit" value="send"></div>
  </form>
{/block}
