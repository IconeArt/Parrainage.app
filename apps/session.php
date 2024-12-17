<?php

function init_session() : bool
{
    if(!session_id())
    {
        session_start();
        session_regenerate_id();
        return true;
    }

    return false;
}

function est_connecter() : bool
{
    if(isset($_SESSION['nomutilisateur']))
        return true;
        
    return false;
}

function est_parrainer() : bool
{
    if(isset($_SESSION['connect']))
        return true;
        
    return false;
}

function detruire_session() : void
{
    session_unset();
    session_destroy();
}