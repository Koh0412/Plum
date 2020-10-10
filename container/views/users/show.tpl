{assign var="title" value=$user->name}
{extends file="layouts/application.tpl"}

{block name=body}
  <div>name: {$user->name}</div>
  <div>age: {$user->age}</div>
{/block}
