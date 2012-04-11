            <div id="content">
                <div class="member">
                    <h3><a href="member.php?id={$fmbMember.mem_id}">{$fmbMember.mem_login}</a></h3>
                    <div class="member">
                        <p>
                            <b>Level :</b>
{if $fmbMember.mem_rights == 1}
                                Administrator
{elseif $fmbMember.mem_rights == 2}
                                Member
{else}
                                Anonymous
{/if}
                        </p>
                    </div>
                </div>
            </div>

