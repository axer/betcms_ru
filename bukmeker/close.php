<?
if (!isset($_SESSION['userId']) || !$_SESSION['userId']) 
fatalError('Доступ закрыт! Авторизуйтесь!<br />
                    <a href="/login">Авторизоваться</a>');