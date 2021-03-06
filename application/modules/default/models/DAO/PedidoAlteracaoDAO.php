<?php
Class PedidoAlteracaoDAO extends Zend_Db_Table{


       	public static function buscarAlteracaoNomeProjeto($idpedidoalteracao)
       	{
       		$sql = "select tpap.idPedidoAlteracao,
                            CAST(pr.ResumoProjeto AS TEXT) AS Objetivos,
                            CAST(tprop.nmProjeto AS TEXT) AS nmProjeto,
                            CAST(tpa.dsJustificativa AS TEXT) AS dsJustificativa
                        from
                            bdcorporativo.scsac.tbPedidoAlteracaoProjeto tpap
                            JOIN sac.dbo.Projetos pr on pr.IdPRONAC = tpap.IdPRONAC
                            JOIN sac.dbo.PreProjeto prep on prep.idPreProjeto = pr.idProjeto
                            JOIN sac.dbo.tbProposta tprop on tprop.idPedidoAlteracao = tpap.idPedidoAlteracao
                            JOIN bdcorporativo.scsac.tbPedidoAlteracaoXTipoAlteracao tpa on tpa.idPedidoAlteracao = tpap.idPedidoAlteracao
                        where
                            tpap.IdPRONAC = $idpedidoalteracao and tpa.tpAlteracaoProjeto = 5 
                        ORDER BY tpap.idPedidoAlteracao DESC";
   
			$db = Zend_Db_Table::getDefaultAdapter();
			$db->setFetchMode(Zend_DB::FETCH_ASSOC);
			$resultado = $db->fetchRow($sql);

			return $resultado;
       	}



        public static function buscarAlteracaoRazaoSocial($idPronac){
            $sql = "select tpap.idPedidoAlteracao,
                        CAST(rs.nmProponente AS TEXT) as nmRazaoSocial,
                        rs.nrCNPJCPF as CgcCpf,
                        CAST(tpa.dsJustificativa AS TEXT) AS dsJustificativa
                    from bdcorporativo.scsac.tbPedidoAlteracaoProjeto tpap
                        INNER JOIN sac.dbo.Projetos pr on pr.IdPRONAC = tpap.IdPRONAC
                        LEFT JOIN sac.dbo.tbProposta tprop on tprop.idPedidoAlteracao = tpap.idPedidoAlteracao
                        INNER JOIN bdcorporativo.scsac.tbPedidoAlteracaoXTipoAlteracao tpa on tpa.idPedidoAlteracao = tpap.idPedidoAlteracao
                        INNER JOIN bdcorporativo.scsac.tbAlteracaoNomeProponente rs on rs.idPedidoAlteracao = tpap.idPedidoAlteracao
                    where
                        tpap.IdPRONAC = $idPronac and tpa.tpAlteracaoProjeto = 2";

            $db = Zend_Db_Table::getDefaultAdapter();
            $db->setFetchMode(Zend_DB::FETCH_ASSOC);
            $resultado = $db->fetchRow($sql);

            return $resultado;
        }


        public static function buscarAlteracaoLocalRealizacao($idPronac, $idPedidoAlteracao = null){

            $sql = "select
                        abran.*
                    from bdcorporativo.scsac.tbPedidoAlteracaoProjeto tpap
                        JOIN sac.dbo.Projetos pr on pr.IdPRONAC = tpap.IdPRONAC
                        JOIN sac.dbo.tbProposta tprop on tprop.idPedidoAlteracao = tpap.idPedidoAlteracao
                        JOIN bdcorporativo.scsac.tbPedidoAlteracaoXTipoAlteracao tpa on tpa.idPedidoAlteracao = tpap.idPedidoAlteracao
                        JOIN sac.dbo.tbAbrangencia abran on abran.idPedidoAlteracao = tpap.idPedidoAlteracao
                    where
                        tpap.IdPRONAC = $idPronac and tpap.idPedidoAlteracao = $idPedidoAlteracao and tpa.tpAlteracaoProjeto = 4";
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->setFetchMode(Zend_DB::FETCH_ASSOC);
            $resultado = $db->fetchRow($sql);

            return $resultado;
        }


        public static function buscarAlteracaoNomeProponente($idPronac){

            $sql = "select tpap.idPedidoAlteracao,
                        CAST(nom.nmProponente AS TEXT) as proponente,
                        nom.nrCNPJCPF as CgcCpf,
                        CAST(tpa.dsJustificativa AS TEXT) AS dsJustificativa
                    from bdcorporativo.scsac.tbPedidoAlteracaoProjeto tpap
                        inner JOIN sac.dbo.Projetos pr on pr.IdPRONAC = tpap.IdPRONAC
                        left join sac.dbo.tbProposta tprop on tprop.idPedidoAlteracao = tpap.idPedidoAlteracao
                        inner JOIN bdcorporativo.scsac.tbPedidoAlteracaoXTipoAlteracao tpa on tpa.idPedidoAlteracao = tpap.idPedidoAlteracao
                        inner JOIN bdcorporativo.scsac.tbAlteracaoNomeProponente nom on nom.idPedidoAlteracao = tpap.idPedidoAlteracao
                    where
                        tpap.IdPRONAC = $idPronac and tpa.tpAlteracaoProjeto = 1";

            $db = Zend_Db_Table::getDefaultAdapter();
            $db->setFetchMode(Zend_DB::FETCH_ASSOC);
            $resultado = $db->fetchRow($sql);

            return $resultado;
            
        }


        public static function buscarAlteracaoFichaTecnica($idPronac){

            $sql = "select tpa.idPedidoAlteracao,
                        CAST(pro.dsFichaTecnica AS TEXT) AS dsFichaTecnica,
                        CAST(tpxa.dsJustificativa AS TEXT) AS dsJustificativa
                from
                        sac.dbo.tbProposta pro
                        inner join bdcorporativo.scsac.tbPedidoAlteracaoProjeto tpa on tpa.idPedidoAlteracao = pro.idPedidoAlteracao
                        inner join bdcorporativo.scsac.tbPedidoAlteracaoXTipoAlteracao tpxa on tpxa.idPedidoAlteracao = tpa.idPedidoalteracao
                where
                    tpa.IdPRONAC = {$idPronac} and tpxa.tpAlteracaoProjeto = 3 ORDER BY tpa.idPedidoAlteracao DESC
                ";

            $db = Zend_Db_Table::getDefaultAdapter();
            $db->setFetchMode(Zend_DB::FETCH_ASSOC);
            $resultado = $db->fetchRow($sql);

            return $resultado;
        }

        public static function buscarAlteracaoPropostaPedagogica($idPronac){

            $sql = "select tpa.idPedidoAlteracao 
                from
                        sac.dbo.tbProposta pro
                        inner join bdcorporativo.scsac.tbPedidoAlteracaoProjeto tpa on tpa.idPedidoAlteracao = pro.idPedidoAlteracao
                        inner join bdcorporativo.scsac.tbPedidoAlteracaoXTipoAlteracao tpxa on tpxa.idPedidoAlteracao = tpa.idPedidoalteracao
                where
                    tpa.IdPRONAC = {$idPronac} and tpxa.tpAlteracaoProjeto = 6 ORDER BY tpa.idPedidoAlteracao DESC
                ";

            $db = Zend_Db_Table::getDefaultAdapter();
            $db->setFetchMode(Zend_DB::FETCH_ASSOC);
            $resultado = $db->fetchRow($sql);

            return $resultado;
        }

        public static function buscarAlteracaoFichaTecnicaFinal($idPronac, $idPedidoAlteracao = null){

            $sql = "select
                        CAST(pro.dsFichaTecnica AS TEXT) AS dsFichaTecnica,
                        CAST(tpxa.dsJustificativa AS TEXT) AS dsJustificativa
                from
                        sac.dbo.tbProposta pro
                        inner join bdcorporativo.scsac.tbPedidoAlteracaoProjeto tpa on tpa.idPedidoAlteracao = pro.idPedidoAlteracao
                        inner join bdcorporativo.scsac.tbPedidoAlteracaoXTipoAlteracao tpxa on tpxa.idPedidoAlteracao = tpa.idPedidoalteracao
                where
                    tpa.IdPRONAC = {$idPronac} and tpa.idPedidoAlteracao = $idPedidoAlteracao and tpxa.tpAlteracaoProjeto = 3
                ";

            $db = Zend_Db_Table::getDefaultAdapter();
            $db->setFetchMode(Zend_DB::FETCH_ASSOC);
            $resultado = $db->fetchAll($sql);

            return $resultado;
        }


        public static function buscarAlteracaoPrazoExecucao($idPronac){
            /*$sql ="select
                    pro.dtInicioExecucao,
                    pro.dtFimExecucao,
                    pro.dsJustificativa
                from
                    sac.dbo.tbProposta pro
                    inner join bdcorporativo.scsac.tbPedidoAlteracaoProjeto pap on pap.idPedidoAlteracao = pro.idPedidoAlteracao
                    inner join bdcorporativo.scsac.tbPedidoAlteracaoXTipoAlteracao tpxa on tpxa.idPedidoAlteracao = pap.idPedidoAlteracao
                where
                    pro.idPedidoAlteracao = {$idpedidoalteracao} and tpxa.tpAlteracaoProjeto = 10";*/

            $sql = "select pap.idPedidoAlteracao,
                        pp.dtInicioNovoPrazo,
                        pp.dtFimNovoPrazo,
                        CAST(tpxa.dsJustificativa AS TEXT) AS dsJustificativa,
                        proj.DtInicioExecucao,
                        proj.DtFimExecucao
                    from
                        bdcorporativo.scsac.tbProrrogacaoPrazo pp
                        INNER JOIN bdcorporativo.scsac.tbPedidoAlteracaoProjeto pap on pap.idPedidoAlteracao = pp.idPedidoAlteracao
                        INNER JOIN bdcorporativo.scsac.tbPedidoAlteracaoXTipoAlteracao tpxa on tpxa.idPedidoAlteracao = pap.idPedidoAlteracao
                        INNER JOIN bdcorporativo.scsac.tbTipoAlteracaoProjeto tap on tap.tpAlteracaoProjeto = tpxa.tpAlteracaoProjeto
                        INNER JOIN sac.dbo.Projetos proj on proj.IdPRONAC = pap.IdPRONAC
                    where
                        pap.IdPRONAC = {$idPronac} and pp.tpProrrogacao = 'E' and tap.tpAlteracaoProjeto = 9 
                    ORDER BY pap.idPedidoAlteracao DESC";

            $db = Zend_Db_Table::getDefaultAdapter();
            $db->setFetchMode(Zend_DB::FETCH_ASSOC);
            $resultado = $db->fetchRow($sql);

            return $resultado;

        }

        public static function buscarAlteracaoPrazoCaptacao($idPronac){
            $sql = "select top 1 pap.idPedidoAlteracao,
                        pp.dtInicioNovoPrazo,
                        pp.dtFimNovoPrazo,
                        CAST(tpxa.dsJustificativa AS TEXT) AS dsJustificativa,
                        proj.DtInicioExecucao,
                        proj.DtFimExecucao,
                        aprov.DtInicioCaptacao,
                        aprov.DtFimCaptacao
                    from
                        bdcorporativo.scsac.tbProrrogacaoPrazo pp
                        INNER JOIN bdcorporativo.scsac.tbPedidoAlteracaoProjeto pap on pap.idPedidoAlteracao = pp.idPedidoAlteracao
                        INNER join bdcorporativo.scsac.tbPedidoAlteracaoXTipoAlteracao tpxa on tpxa.idPedidoAlteracao = pap.idPedidoAlteracao
                        INNER JOIN bdcorporativo.scsac.tbTipoAlteracaoProjeto tap on tap.tpAlteracaoProjeto = tpxa.tpAlteracaoProjeto
                        INNER JOIN sac.dbo.Projetos proj on proj.IdPRONAC = pap.IdPRONAC
                        INNER JOIN sac.dbo.Aprovacao aprov on aprov.AnoProjeto+aprov.Sequencial = proj.AnoProjeto+proj.Sequencial
                    where
                        pap.IdPRONAC = $idPronac and pp.tpProrrogacao = 'C' and tap.tpAlteracaoProjeto = 8 and aprov.TipoAprovacao in (1,3)
                    order by pap.idPedidoAlteracao desc";

            $db = Zend_Db_Table::getDefaultAdapter();
            $db->setFetchMode(Zend_DB::FETCH_ASSOC);
            $resultado = $db->fetchRow($sql);

            return $resultado;

        }

        public static function salvarComentarioAlteracaoProj($dados){
            $objAcesso= new Acesso();
            $sql = "insert into sac.dbo.tbDiligencia
                        (
                            idPronac,
                            idTipoDiligencia,
                            DtSolicitacao,
                            Solicitacao,
                            idSolicitante,
                            stEstado
                        )
                    values
                        (
                            {$dados['idPronac']},
                            124,
                            {$objAcesso->getDate()},
                            '{$dados['Solicitacao']}',
                            {$dados['idSolicitante']},
                            0
                        )";

                            die($sql);
        }
       	
}