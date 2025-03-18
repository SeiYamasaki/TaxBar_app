<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaxBar® | 税理士の方へ</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body class="bg-white overflow-auto min-h-screen">
    <!-- ✅ ヘッダーを固定 -->
    <header class="fixed top-0 left-0 w-full h-16 bg-white shadow-lg z-50 flex items-center">
        @include('components.header')
    </header>

    <!-- ✅ ヘッダーの高さ分だけ余白を確保 (mt-32) -->
    <div class="max-w-screen-lg mx-auto mt-32 px-6 sm:px-10 py-6">
        <h2 class="text-center text-3xl font-bold mb-6">
            公認会計士･税理士又は税理士の方へ</h2>

        <!-- ✅ 1. TaxBar®の目的 -->
        <div class="mb-8">
            <h4 class="text-3xl font-semibold mb-2">1. TaxBar®の目的はなにか</h4>
            <div class="w-full h-1 bg-gradient-to-r from-red-500 via-yellow-500 to-blue-500 mb-4"></div>
            <p class="leading-relaxed text-lg sm:text-xl">
                税理士の｢不便｣や｢不安｣を解消すること､及び税理士による｢集客｣に貢献するためのWebアプリサイトです｡<br />
                開業したばかりの税理士にも始めやすいように､高額な初期投資を抑えるためサブスクリプション制としています｡<br />
                本Webアプリサイトによるサービスのみならず､税理士のご要望や現在のお困りごとを、細部に渡ってお伺いします。<br />
                ご不明な点や他のご要望等のご相談は遠慮なく<a href="/inquiry" class="text-blue-600 underline">お問い合わせ</a>ください｡<br />
                4,200所以上の税理士事務所、Engineer500名超の体制により培ったノウハウをもとに、税理士の潜在的なニーズまでも掘り起こし、税理士の先生方々又は税理士法人に貢献いたします｡
                私たちのWebアプリは、税理士の先生方が直面するさまざまな課題を解決し、より効率的で生産的な業務運営を可能にすることを目的としています。現代のビジネス環境において、税理士の役割は単なる税務申告の代行にとどまらず、経営者の財務パートナーとしての役割も担っています。そのため、業務の効率化や新規顧客の獲得、継続的なクライアントの満足度向上が重要なポイントとなります。
                特に新しいクライアントを獲得することは、特に開業間もない税理士にとって大きな課題です。TaxBar®は、集客を強力にサポートします。
                税理士業務は個人で行うことが多いため、専門家同士のつながりを持つことは重要です。TaxBar®は、税理士間の情報共有を促進し、協業の機会を創出します。
                TaxBar®は、税理士の皆様が直面する課題を解決し、よりスムーズで効率的な業務運営を可能にします。新規顧客獲得、業務の効率化、ネットワークの拡大など、多方面にわたる支援を提供することで、税理士業界全体の発展に貢献します。
                ぜひ、TaxBar®を活用し、業務の可能性を広げてください。今後のサービス向上に向けたご意見やご要望も随時受け付けておりますので、お気軽にお問い合わせください。
                <br />
                <a href="/register/select" class="text-blue-600 underline">▶ TaxBar® に登録する</a>
            </p>
            <div class="text-center mt-4">
                <img src="{{ asset('images/logotoumei.png') }}" alt="TaxBar®ロゴ"
                    class="mx-auto rounded-lg shadow-lg w-56">
            </div>
        </div>

        <div class="mb-8">
            <h4 class="text-3xl font-semibold mb-2">2. 税理士のペイン</h4>
            <div class="w-full h-1 bg-gradient-to-r from-pink-500 via-purple-500 to-indigo-500 mb-4"></div>
            <!-- レインボー罫線 -->
            <p class="leading-relaxed text-lg sm:text-xl">
                TaxBar®のFounderは､約20年の会計税務の業務経験があります｡<br />
                税理士試験及び公認会計士試験の経験者でもあります｡<br />
                法人税1000社以上､所得税500社以上の処理を経験しています｡<br />
                上場企業の開示業務経験や株主総会実務も経験しています｡<br />
                近々では､法人税納付額3500万円規模の法人の処理にあたりました｡<br />
                税理士業務には精通しております｡しかも､Engineerです｡<br />
                現在､税理士にかかる集客においては､仕入れ代として高額な料金を支払っている事務所が数多くおられます｡<br />
                これでは､年間の税理士報酬から支払う仕入れ代に加えて人件費を支払うとほぼ儲かりません｡<br />
                支払ったにもかかわらず､顧客と連絡がとれない､さらに支払った仕入れ代は返ってこないなど､泣き寝入りする事務所が増えました｡<br />
                また､顧客の数はあるものの､赤字法人ばかりで利益が出てちゃんと法人税を支払っている法人を顧客にしたいなどのニーズもあるかと思います｡<br />
                既存の顧客に契約の打ち切りを申し出て､新たな質の良い顧客と契約していかなければならないゴーイングコンサーンを前提とするペインも存在します｡<br />
                その他､既存の顧客からの紹介は"しがらみ"が発生し､善良なる税務判断に支障がでることもあります｡<br />
                これらの税理士のペインを解消するためにTaxBar®はあります｡<br />
                <br />
                <a href="/register/select" class="text-blue-600 underline">▶ TaxBar® に登録する</a>

            </p>
            <div class="text-center mt-4">
                <img src="{{ asset('images/souzoku_6.jpeg') }}" alt="選定・調整"
                    class="mx-auto rounded-lg shadow-lg w-56">
            </div>
        </div>

        <div class="mb-8">
            <p class="leading-relaxed text-lg sm:text-xl">
                <h4 class="text-3xl font-semibold mb-2">3. 税理士業界の市場規模</h4>
            <div class="w-full h-1 bg-gradient-to-r from-green-500 via-teal-500 to-cyan-500 mb-4"></div>
            <!-- レインボー罫線 -->
            <p class="leading-relaxed text-lg sm:text-xl">
                日本の税理士業界は、全国で約8万人の税理士が登録され、約4万2,000の税理士事務所が存在し、市場規模は約2兆円と推定されている。税理士業務は、法人税・所得税の申告支援、相続税対策、記帳代行、経営コンサルティングなど多岐にわたり、特に中小企業や個人事業主の支援が中心となっている。
                近年、電子申告の普及やAI・RPAの導入により、従来の記帳代行業務の需要は減少傾向にあるが、税務相談や経営アドバイスなどの高付加価値業務の需要は増加している。特に、企業の税務リスク管理やM&A、事業承継の支援業務は成長分野となっている。
                しかし、税理士の高齢化が進み、平均年齢は60歳を超えており、後継者不足が深刻な課題となっている。新規参入者が減少する中、IT技術を活用した業務効率化が求められている。
                さらに、インボイス制度の導入や電子帳簿保存法の改正により、企業が税理士を必要とする場面は増加している。特に、小規模事業者向けの税務サポート市場が拡大しており、クラウド会計ソフトとの連携や、税務相談のオンライン化が進んでいる。
                税理士業界は、従来の業務モデルからデジタル化と専門性の向上を前提とした新たな時代へと移行している。今後は、AIを活用した税務アドバイスの自動化、オンライン会議システムの活用、税理士同士のネットワーク強化など、より付加価値の高いサービスが求められる。
                また、税務コンプライアンスの強化により、顧問契約を通じた長期的な関係構築が重要となっている。税理士が顧客とどのように信頼関係を築き、業務の幅を広げていくかが今後の成長の鍵となるだろう。
                <br />
                <a href="/register/select" class="text-blue-600 underline">▶ TaxBar® に登録する</a>
            </p>
            <div class="text-center mt-4">
                <img src="{{ asset('images/robo1.gif') }}" alt="面会" class="mx-auto rounded-lg shadow-lg w-56">
            </div>
        </div>

        <div class="mb-8">
            <p class="leading-relaxed text-lg sm:text-xl">
                <h4 class="text-3xl font-semibold mb-2">4. 税理士に対する支援体制</h4>
            <div class="w-full h-1 bg-gradient-to-r from-orange-500 via-yellow-500 to-lime-500 mb-4"></div>
            <!-- レインボー罫線 -->
            <p class="leading-relaxed text-lg sm:text-xl">
                税理士業界では、新規顧客の獲得と安定した顧問契約の維持が大きな課題となっています。特に、開業税理士や独立を考えている税理士にとって、競争の激しい市場で効率的に集客を行うことは難しく、既存の広告手法では高額なコストがかかるケースも多く見られます。そこで、TaxBar®
                は、<a href="https://note.com/spqrjp/n/ne8056785ebff"
                    class="text-blue-600 underline">「スパルタキャンプ（SpartaCamp）」</a>で鍛えられた500名超のエンジニアチーム
                と連携し、最先端のデジタル技術を活用した税理士向けの集客支援
                を提供します。まず、AIを活用した税理士専用マッチングプラットフォーム により、TaxBar®独自のAIが税理士をサポートしています｡スパルタキャンプ出身のエンジニアが開発した機械学習アルゴリズム
                により、税理士業務補助を実現しています｡さらに、SNS広告・Webマーケティングの自動化
                により、より広範囲の見込み客にアプローチ。スパルタキャンプのAIエンジニアが開発した広告最適化システムを活用し、Facebook広告やInstagram広告をターゲットとなる企業経営者や個人事業主
                に向けて配信。AIが広告運用を最適化し、クリック率やコンバージョン率を向上させ、コストを抑えつつ効率的な集客を実現します。そして、口コミマーケティングの活用
                により、顧客満足度の高い税理士事務所をより多くの人に認知してもらう仕組みを構築。スパルタキャンプ出身のエンジニアが開発した自動レビュー収集ツール
                により、クライアントからのフィードバックを収集し、信頼性の高いレビューをWebサイトやSNSで発信。これにより、税理士のブランド力を向上させ、新規顧客の獲得につなげます。このように、TaxBar®
                はスパルタキャンプのエンジニアチームと連携し、AIマッチング・SEO対策・SNS広告・オンライン相談・口コミマーケティングを組み合わせた包括的な集客支援
                を行い、税理士の顧客獲得を効率化します。<br />
                <a href="/register/select" class="text-blue-600 underline">▶ TaxBar® に登録する</a>
            </p>
            <div class="text-center mt-4">
                <img src="{{ asset('images/robo2.gif') }}" alt="契約" class="mx-auto rounded-lg shadow-lg w-56">
            </div>
        </div>
        <!-- ✅ 5. TaxBar® の今後の展望 -->
        <div class="mb-8">
            <h4 class="text-3xl font-semibold mb-2">5. TaxBar® の今後の展望</h4>
            <div class="w-full h-1 bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 mb-4"></div>
            <!-- レインボー罫線 -->
            <p class="leading-relaxed text-lg sm:text-xl">
                TaxBar® は、税理士業界のデジタルトランスフォーメーション（DX）を推進し、より多くの税理士が効率的に業務を遂行できるよう支援することを目指しています。<br />
                その中核として、<a href="https://note.com/spqrjp/n/ne8056785ebff" class="text-blue-600 underline">SpartaCamp</a>
                出身のエンジニア500名以上が開発に携わり、革新的なシステムとサービスを提供します。今後は、AIを活用した税務相談機能の導入、オンライン会議機能の強化、さらに税理士同士のネットワークを広げるためのプラットフォーム化を進めていきます。<br /><br />

                まず、AIによる税務アドバイスの自動化を実現し、クライアントの基本的な税務相談を迅速に対応できるようにします。AIが税務データを解析し、適切なアドバイスを提供することで、税理士がより高度な業務に集中できる環境を整えます。SpartaCamp
                出身のエンジニアチームが開発する**「AI税務アシスタント」** により、クライアントとのコミュニケーションの円滑化を図ります。<br /><br />

                次に、オンライン会議機能の拡充として、クライアントとの面談をスムーズに行える**「TaxBar® オンラインミーティングシステム」**
                を開発中です。このシステムは、予約管理や顧客対応を自動化し、Web上での面談の利便性を向上させます。また、録画機能や自動文字起こし機能を追加し、業務の記録・管理を効率化します。<br /><br />

                さらに、税理士間のネットワークを強化し、**「税理士向けビジネスマッチングプラットフォーム」**
                を構築。税理士同士が業務提携しやすい環境を整え、相続税や国際税務などの専門分野を持つ税理士との協業を促進します。これにより、単独では対応できない業務にも柔軟に対応できる仕組みを提供します。<br /><br />

                また、税理士事務所の運営最適化を支援するために、**「TaxBar® クラウド管理システム」**
                を導入予定。契約管理、請求処理、クライアントデータの統合管理を可能にし、事務作業の負担を軽減します。<br /><br />

                <a href="/register/select" class="text-blue-600 underline">▶ TaxBar® に登録する</a>
            </p>
            <div class="text-center mt-4">
                <img src="{{ asset('images/TaxBar_9.jpeg') }}" alt="TaxBar® の今後の展望"
                    class="mx-auto rounded-lg shadow-lg w-56">
            </div>
        </div>
    </div>

    <!-- ✅ フッター追加 -->
    <footer class="bg-gray-200 text-center py-4">
        @include('components.footer')
    </footer>

</body>

</html>
