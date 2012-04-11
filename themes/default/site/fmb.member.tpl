            <div id="content">
                <div class="member">
                    <h3><a href="member.php?id={$fmbMember.mem_id}">{$fmbMember.mem_login}</a></h3>
                    <div class="member">
                        <p>
                            <b>Niveau :</b>
{if $fmbMember.mem_rights == 1}
                                Administrateur
{elseif $fmbMember.mem_rights == 2}
                                Membre
{else}
                                Anonyme
{/if}
                        </p>
                    </div>
                </div>
            </div>

