<?php

//Getting Elementor PRO forms or current form
global $wpdb;
$main_table = $wpdb->prefix . "collects";
$mytables = $wpdb->get_results("SHOW TABLES");
$all_forms = array();
if (isset($_GET["form"]) && sanitize_text_field($_GET["form"]) != "all") {
    $all_forms[] = $wpdb->prefix . "collects_" . sanitize_text_field($_GET["form"]);
} else {
    foreach ($mytables as $mytable) {
        foreach ($mytable as $t) {
            if (strpos($t, $main_table) === 0 && $t != $main_table) {
                $all_forms[] = $t;
            }
        }
    }
}

// Correct update url query dates
function UETR_format_form_url($form)
{
    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
    $url_arr = parse_url($actual_link);
    parse_str($url_arr['query'], $query);
    if (isset($query['form'])) {
        $query['form'] = $form;
    } else {
        $inserted = array();
        $inserted["form"] = $form;
        $query = array_merge(array_slice($query, 0, 1), $inserted, array_slice($query, 1 - count($query)));
    }
    $url_arr['query'] = http_build_query($query);
    $out = $url_arr["scheme"] . "://" . $url_arr["host"] . $url_arr["path"] . "?" . $url_arr["query"];

    return $out;
}

?>

<?php
//Get all data for display by current period

$tomorrow = new DateTime("now");
$tomorrow->add(new DateInterval('P1D'));
$weekago = new DateTime("-6 days");
$yearago = new DateTime("-365 days");
if (isset($_GET["start"])) {
    $start = sanitize_text_field($_GET["start"]);
    $startdate = "'" . $start . "'";
    $startdate_line = new DateTime($start);
} else {
    $startdate = "'" . $weekago->format('Y-m-d') . "'";
    $startdate_line = $yearago;
}

if (isset($_GET["end"])) {
    $end = sanitize_text_field($_GET["end"]);
    $enddate = "'" . $end . "'";
    $enddate_line = new DateTime($end);
    $enddate_line->add(new DateInterval('P1D'));
} else {
    $enddate = "'" . $tomorrow->format('Y-m-d') . "'";
    $enddate_line = $tomorrow;
}
if (!isset($_GET["end"]) || !isset($_GET["start"])) {
    $current_tab_val = -1;
} else {
    $current_tab_val = $enddate_line->diff($startdate_line)->days - 1;
}

$all_source = array();
$all_medium = array();
$all_by_dates = array();
$totel_leads = 0;
$leadsbyform = array();
foreach ($all_forms as $form) {

    $query = "SELECT count(id) as cnt FROM " . $form;
    $leads_count = $wpdb->get_results($query, ARRAY_A);
    $totel_leads += $leads_count[0]["cnt"];
    $form_id = str_replace($wpdb->prefix . "collects_", "", $form);
    $query = "SELECT form_name FROM " . $main_table . " WHERE id=" . $form_id;
    $curr_table = $wpdb->get_results($query, ARRAY_A);
    $leadsbyform[$curr_table[0]["form_name"]] = $leads_count[0]["cnt"];

    if (!isset($_GET["end"]) || !isset($_GET["start"])) {
        $query = "SELECT utm_source, count(utm_source) as count FROM " . $form . " Group By utm_source";
    } else {
        $query = "SELECT utm_source, count(utm_source) as count FROM " . $form . " WHERE date >= DATE " . $startdate . " AND date <= DATE " . $enddate . " Group By utm_source";
    }
    $curr_sources = $wpdb->get_results($query, ARRAY_A);
    foreach ($curr_sources as $item) {
        if ($item["utm_source"]) {
            if (isset($all_source[$item["utm_source"]])) {
                $all_source[$item["utm_source"]] += $item["count"];
            } else {
                $all_source[$item["utm_source"]] = $item["count"];
            }
        }
    }

    if (!isset($_GET["end"]) || !isset($_GET["start"])) {
        $query = "SELECT utm_medium as utm_source, count(utm_medium) as count FROM " . $form . " Group By utm_medium";
    } else {
        $query = "SELECT utm_medium as utm_source, count(utm_medium) as count FROM " . $form . " WHERE date >= DATE " . $startdate . " AND date <= DATE " . $enddate . " Group By utm_medium";
    }
    $curr_medium = $wpdb->get_results($query, ARRAY_A);
    foreach ($curr_medium as $item) {
        if ($item["utm_source"]) {
            if (isset($all_medium[$item["utm_source"]])) {
                $all_medium[$item["utm_source"]] += $item["count"];
            } else {
                $all_medium[$item["utm_source"]] = $item["count"];
            }
        }
    }

    if (!isset($_GET["end"]) || !isset($_GET["start"])) {
        $query = "SELECT date, utm_source, utm_medium FROM " . $form;
    } else {
        $query = "SELECT date, utm_source, utm_medium FROM " . $form . " WHERE date >= DATE " . $startdate . " AND date <= DATE " . $enddate;
    }
    $curr_by_dates = $wpdb->get_results($query, ARRAY_A);
    $all_by_dates = array_merge($all_by_dates, $curr_by_dates);

    $per_source = array();
    $per_medium = array();
    foreach ($all_by_dates as $item) {
        if (isset($per_source[$item["utm_source"]])) {
            if (isset($per_source[$item["utm_source"]][$item["date"]])) {
                $per_source[$item["utm_source"]][$item["date"]] += 1;
            } else {
                $per_source[$item["utm_source"]][$item["date"]] = 1;
            }
        } else {
            $per_source[$item["utm_source"]][$item["date"]] = 1;
        }
        if (isset($per_medium[$item["utm_medium"]])) {
            if (isset($per_medium[$item["utm_medium"]][$item["date"]])) {
                $per_medium[$item["utm_medium"]][$item["date"]] += 1;
            } else {
                $per_medium[$item["utm_medium"]][$item["date"]] = 1;
            }
        } else {
            $per_medium[$item["utm_medium"]][$item["date"]] = 1;
        }
    }
    $leads = $leads_medium = array();

    $period = new DatePeriod(
        $startdate_line,
        new DateInterval('P1D'),
        $enddate_line
    );
    foreach ($period as $date) {
        foreach ($per_source as $source => $list) {
            if ($source != "") {
                $leads[$source][$date->format("Y-m-d")] = 0;
                if (isset($per_source[$source][$date->format("Y-m-d")])) {
                    $leads[$source][$date->format("Y-m-d")] = $per_source[$source][$date->format("Y-m-d")];
                }
            } else {
                $leads["other"][$date->format("Y-m-d")] = 0;
                if (isset($per_source[$source][$date->format("Y-m-d")])) {
                    $leads["other"][$date->format("Y-m-d")] = $per_source[$source][$date->format("Y-m-d")];
                }
            }
        }
        foreach ($per_medium as $medium => $list) {
            if ($medium != "") {
                $leads_medium[$medium][$date->format("Y-m-d")] = 0;
                if (isset($per_medium[$medium][$date->format("Y-m-d")])) {
                    $leads_medium[$medium][$date->format("Y-m-d")] = $per_medium[$medium][$date->format("Y-m-d")];
                }
            } else {
                $leads_medium["other"][$date->format("Y-m-d")] = 0;
                if (isset($per_medium[$medium][$date->format("Y-m-d")])) {
                    $leads_medium["other"][$date->format("Y-m-d")] = $per_medium[$medium][$date->format("Y-m-d")];
                }
            }
        }
    }
}


?>
<div class="tab">
    <div class="title">
        <p>UE Tracker - UTM Track and Analyze Leads For Elementor</p>
        <p class="company">By GemPlan</p>
    </div>
    <hr>
    <div class="tabs">
        <button class="tablinks" onclick="openTab(event, 'letsstart')">Let’s Start</button>
        <button class="tablinks active" onclick="openTab(event, 'dashboard')">Dashboard</button>
        <button class="tablinks" onclick="openTab(event, 'channelsmap')">Channels Map</button>
        <button class="tablinks" onclick="openTab(event, 'utm_builder')">UTM Builder</button>
    </div>
    <div class="filters" data-test="<?php echo $current_tab_val; ?>">
        <div>
            <a href="#" class="dates <?php if ($current_tab_val == -1) {
                echo "active";
            } ?>" data-time="-1">All time</a>
        </div>
        <div>
            <a href="#" class="dates <?php if ($current_tab_val == 1) {
                echo "active";
            } ?>" data-time="1">Daily</a>
        </div>
        <div>
            <a href="#" class="dates <?php if ($current_tab_val == 7) {
                echo "active";
            } ?>" data-time="7">Weekly</a>
        </div>
        <div>
            <a href="#" class="dates <?php if ($current_tab_val == 30) {
                echo "active";
            } ?>" data-time="30">Monthly</a>
        </div>
        <div>
            <a href="#" class="dates <?php if ($current_tab_val == 365) {
                echo "active";
            } ?>" data-time="365">Yearly</a>
        </div>
        <div>
            Choose Dates
        </div>
        <div id="reportrange"
             style="cursor: pointer; padding: 5px 10px; border: 1px solid #122c3f; width: 100%; color: #122c3f;">
            <i class="fa fa-calendar"></i>&nbsp;
            <span></span> <i class="fa fa-caret-down"></i>
        </div>

        <?php
        $query = "SELECT * FROM " . $main_table;
        $curr_table = $wpdb->get_results($query, ARRAY_A);

        if (isset($_GET["form"]) && sanitize_text_field($_GET["form"]) != "all") {
            foreach ($curr_table as $form) {
                if ($form["id"] == sanitize_text_field($_GET["form"])) {
                    $drop_title = $form["form_name"];
                }
            }
        } else {
            $drop_title = "ALL";
        }
        ?>
        <div>
            Choose Form
        </div>
        <div class="dropdown">
            <button class="dropbtn"><?php echo $drop_title; ?></button>
            <div class="dropdown-content">
                <a href="<?php echo UETR_format_form_url("all"); ?>" data-form="all"
                   class="<?php if (isset($_GET["form"]) && sanitize_text_field($_GET["form"]) == "all") {
                       echo "active";
                   } ?>">All</a>
                <?php
                foreach ($curr_table as $form) {
                    if (isset($_GET["form"]) && sanitize_text_field($_GET["form"]) == $form["id"]) {
                        $clss = "active";
                    } else {
                        $clss = "";
                    }
                    echo '<a href="' . UETR_format_form_url($form["id"]) . '" data-form="' . $form["id"] . '" class="' . $clss . '">' . $form["form_name"] . '</a>';
                } ?>
            </div>
        </div>
    </div>
    <hr class="bottom_hr">

</div>

<div id="letsstart" class="tabcontent" style="display:none;">
    <h2>Details:</h2>

    <p>Discover which marketing campaigns are actually profitable; which are wasting your time and money. UE Tracker -
        UTM Track and Analyze Elementor Leads by Gemplan plug-in collects the lead’s source and displays it in the
        WordPress Dashboard, alongside all of the lead’s details including their email. This add-on for Elementor tracks
        the effectiveness of your marketing campaigns and helps you identify the winners. Easy peasy.</p>
    <p>Once you discover your customer's email from its traffic source, you can easily understand which advertising
        channels are relevant, not just in terms of leads, but also in terms of sales.</p>
    <p>Facebook, Google, Twitter, YouTube, Instagram, various blogs or any advertising channel you choose - you can
        easily track all traffic from one place.</p>

    <h2>How do you do it?</h2>

    <p>It’s easy and straightforward!</p>
    <p>1. Install the UE tracker on your site and activate it.</p>
    <p>2. Enter the UE Tracker settings area (in the WP sidebar).</p>
    <p>3. Go to UTM tab.</p>
    <p>4. Create a unique link for each advertising channel based on the parameters of your choice.</p>
    <p>5. View UE Tracker's dashboard and see right away where your best traffic is coming from</p>

    <h2>Want more?</h2>

    <p>Once the lead becomes a customer, you can check the UE Tracker according to the customer's email, from where it
        originated. That way you can find out which source produced the highest quality leads!!</p>

    <h2>What UE Tracker includes</h2>

    <p>UTM creator tool with all the parameters you could need & viewing option to see all the UTMs you created to avoid
        any errors</p>
    <p>Dashboard - see all sources of traffic in one single spot. Leads, emails, and all interesting data on leads.</p>
    <p>Channel map - A visual display providing an overview of all traffic sources to easily compare them at a
        glance</p>

    <h2>Why did we create it?</h2>
    <p>Whenever we came across a new lead, we wanted to know its source.</p>
    <p>At first, we relied on guesswork and spent a whole lot of time processing the data. This meant that we couldn’t
        expand our marketing efforts.</p>
    <p>Plus, we wanted one place where we could read the connection between each lead and our landing source. This way
        we could not only see where the leads came from but also we wanted to see all the data- traffic source and lead
        details in the WordPress panel.</p>
    <p>To solve this problem, we built the UE Tracker - UTM Track and Analyze Elementor Leads by Gemplan.</p>
    <p>If you can add UTM parameters to your links, the UE tracker - UTM Track and Analyze Elementor Leads by Gemplan
        elements will show you the source of your visitor as soon as they are converted into a lead.</p>
    <p>Let's say you promote your products on Facebook and set the UTM parameters as UTM_SOURCE.</p>
    <p>After registering a contact form or invitations from you in this directory, these parameters will be listed
        alongside the contact information.</p>
    <p>You can track the source of your leads directly from WordPress without having to visit any further platforms.</p>
    <p>It tells you which channels attract more potential customers, and providing you with the bigger picture of the
        actual effectiveness of your marketing campaigns.</p>
    <p>So use this and track the source of your leads hassle-free.</p>

</div>

<div id="dashboard" class="tabcontent" style="display:block;">

    <?php if ($totel_leads == 0) {
        ; ?>
        <div class="empty_data">It's time to start earning!
            Enter the UE Tracker-UTM BUILDER, create a unique link to your campaigns and the data will start flowing and
            reveal where the winning leads come from!
            It’s easy!
        </div>

    <?php } else {
        ; ?>
        <div class="row-flex">
            <div class="column-flex">
                <div class="char-title">Total Leads</div>
                <p><?php echo $totel_leads; ?></p>
            </div>
            <div class="column-flex">
                <?php if (count($leadsbyform) > 0) {
                    $top_form = "\"" . array_keys($leadsbyform, max($leadsbyform))[0] . "\"";
                } else {
                    $top_form = "";
                } ?>
                <div class="char-title">Top Form</div>
                <p><?php echo $top_form; ?></p>
            </div>
            <div class="column-flex">
                <div class="char-title">Top Sources</div>
                <canvas id="pie_all" class="" data-source='<?php echo json_encode($all_source); ?>'></canvas>
            </div>
            <div class="column-flex">
                <div class="char-title">Top Mediums</div>
                <canvas id="pie_med_all" class=""
                        data-source='<?php echo json_encode($all_medium); ?>'></canvas>
            </div>
        </div>

        <div class="export_block">
            <p>Leads Details</p>
            <hr>
            <div id="export_to_csv">Export CSV</div>
        </div>


        <?php
        $f = 1;
        if (count($all_forms) > 1) { ?>
            <div class="table100 ver3 m-b-110 table100-body js-pscroll ps ps--active-y" style="margin: 30px;">
                <table id="all_forms" class="filter_table table_to_export">
                    <thead>
                    <tr class="row100 head">
                        <th class="cell100 ">id</th>
                        <th class="cell100 ">name</th>
                        <th class="cell100 ">email</th>
                        <th class="cell100 ">message</th>
                        <th class="cell100 ">date</th>
                        <th class="cell100 ">utm_source</th>
                        <th class="cell100 ">utm_medium</th>
                        <th class="cell100 ">utm_campaign</th>
                        <th class="cell100 ">utm_term</th>
                        <th class="cell100 ">utm_content</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    $curr_id = 1;
                    foreach ($all_forms as $form) {
                        $query = "DESCRIBE " . $form;
                        $curr_table_schema = $wpdb->get_results($query, ARRAY_A);

                        if (!isset($_GET["end"]) || !isset($_GET["start"])) {
                            $query = "SELECT * FROM " . $form;
                        } else {
                            $query = "SELECT * FROM " . $form . " WHERE date >= DATE " . $startdate . " AND date <= DATE " . $enddate;
                        }
                        $curr_table = $wpdb->get_results($query, ARRAY_A);
                        ?>
                        <?php

                        foreach ($curr_table as $row) { ?>
                            <tr class="row100 body">
                                <td class="cell100"><?php echo $curr_id; ?></td>
                                <td class="cell100"><?php if (isset($row["name"])) {
                                        echo $row["name"];
                                    } ?></td>
                                <td class="cell100"><?php if (isset($row["email"])) {
                                        echo $row["email"];
                                    } ?></td>
                                <td class="cell100"><?php if (isset($row["message"])) {
                                        echo $row["message"];
                                    } ?></td>
                                <td class="cell100"><?php if (isset($row["date"])) {
                                        echo $row["date"];
                                    } ?></td>
                                <td class="cell100"><?php if (isset($row["utm_source"])) {
                                        echo $row["utm_source"];
                                    } ?></td>
                                <td class="cell100"><?php if (isset($row["utm_medium"])) {
                                        echo $row["utm_medium"];
                                    } ?></td>
                                <td class="cell100"><?php if (isset($row["utm_campaign"])) {
                                        echo $row["utm_campaign"];
                                    } ?></td>
                                <td class="cell100"><?php if (isset($row["utm_term"])) {
                                        echo $row["utm_term"];
                                    } ?></td>
                                <td class="cell100"><?php if (isset($row["utm_content"])) {
                                        echo $row["utm_content"];
                                    } ?></td>
                            </tr>
                            <?php $curr_id++;
                        } ?>
                        <?php $f++;
                    }
                    ?>
                    </tbody>
                </table>

            </div>
            <?php
        } else {
            foreach ($all_forms as $form) {
                $query = "DESCRIBE " . $form;
                $curr_table_schema = $wpdb->get_results($query, ARRAY_A);

                $query = "SELECT * FROM " . $form;
                $curr_table = $wpdb->get_results($query, ARRAY_A);
                ?>

                <div class="table100 ver3 m-b-110 table100-body js-pscroll ps ps--active-y" style="margin: 30px;">
                    <table id="<?php echo $form; ?>" class="filter_table table_to_export">
                        <thead>
                        <tr class="row100 head">
                            <?php
                            $i = 1;
                            foreach ($curr_table_schema as $head) {
                                ?>
                                <th class="cell100 <?php //echo $i; ?>"><?php echo $head['Field']; ?></th>
                                <?php $i++;
                            } ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($curr_table as $row) { ?>
                            <tr class="row100 body">
                                <?php
                                $i = 1;
                                foreach ($row as $item) { ?>
                                    <td class="cell100 <?php //echo $i; ?>"><?php echo $item; ?></td>
                                    <?php $i++;
                                } ?>
                            </tr>
                        <?php } ?>

                        </tbody>
                    </table>

                </div>
                <?php $f++;
            }
        }
        ?>
    <?php }; ?>
</div>

<div id="channelsmap" class="tabcontent" style="display:none;">

    <?php if ($totel_leads == 0) {
        ; ?>
        <div class="empty_data">There is nothing like a graph to compare data.
            It produces your first UTM with the help of the UTM BUILDER UE Tracker to start seeing the results live.
            It’s a cinch!
        </div>

    <?php } else {
        ; ?>
        <div class="line-chart-block">
            <div class="tab" style="display: inline-block;">
                <button class="tablinksinner active" onclick="openTabInner(event, 'source')">Source</button>
                <button class="tablinksinner" onclick="openTabInner(event, 'medium')">Medium</button>
            </div>
            <div id="source" class="tabcontentinner" style="display:block;height: 400px;">
                <canvas id="line_canvas" class=""></canvas>
            </div>
            <div id="medium" class="tabcontentinner" style="display:none;height: 400px;">
                <canvas id="line_canvas_medium" class=""></canvas>
            </div>
        </div>
    <?php }; ?>
</div>

<div id="utm_builder" class="tabcontent" style="display:none;">
    <?php
    $utm_table_name = $wpdb->prefix . "utm_builder";

    $query = "DESCRIBE " . $utm_table_name;
    $curr_table_schema = $wpdb->get_results($query, ARRAY_A);

    $query = "SELECT * FROM " . $utm_table_name;
    $curr_table = $wpdb->get_results($query, ARRAY_A);
    $total_utm = count($curr_table);
    ?>
    <div class="row-flex">
        <form name="utmBuilder" class="utm-form form-horizontal column-flex" onsubmit="BuildUTM(); return false;">
            <div class="form-group">
                <label for="website" class="col-sm-4">Website URL*</label>
                <div class="col-sm-8">
                    <input id="website" size="20" type="url" pattern="" value=""
                           placeholder="http://www.yourdomain.com/" required>
                </div>
            </div>
            <div class="form-group">
                <label for="campaignSource" class="col-sm-4">Campaign Source</label>
                <div class="col-sm-8">
                    <input id="campaignSource" type="text" size="20"
                           placeholder="referrer: google, emailnewsletter2, facebook" value="">
                </div>
            </div>
            <div class="form-group">
                <label for="campaignMedium" class="col-sm-4">Campaign Medium</label>
                <div class="col-sm-8">
                    <input id="campaignMedium" type="text" size="20"
                           placeholder="marking medium: cpc, banner, email, social" value="">
                </div>
            </div>
            <div class="form-group">
                <label for="campaignName" class="col-sm-4">Campaign Name</label>
                <div class="col-sm-8">
                    <input id="campaignName" type="text" size="20" placeholder="e.g. product, promo code, slogan"
                           value="">
                </div>
            </div>
            <div class="form-group">
                <label for="campaignTerm" class="col-sm-4">Campaign Term</label>
                <div class="col-sm-8">
                    <input id="campaignTerm" type="text" size="20" placeholder="(optional) Identify the paid keywords"
                           value="">
                </div>
            </div>
            <div class="form-group">
                <label for="campaignContent" class="col-sm-4">Campaign Content</label>
                <div class="col-sm-8">
                    <input id="campaignContent" type="text" size="20" placeholder="(optional) use to differentiate ads"
                           value="">
                </div>
            </div>
            <div class="form-line-utm-right">
                <input class="" onclick="BuildUTM(); return false;" type="button" value="Build URL">
                <input class="" style="margin-left: 10px;" onclick="clearUTM();" type="button" value="Clear URL">
            </div>
            <div class="form-line-utm">
                <strong>Your Generated URL:</strong><br> <br>
                <input class="copylink" id="generatedUrl" onclick="highlight(this);" type="text" size="60" value="">
                <input id="copybutton" class="copytext" onclick="copy('#generatedUrl')"
                       data-clipboard-target="generatedUrl"
                       type="button" value="Copy URL">
                <p></p>
                <div class="mailmunch-forms-in-post-middle" style="display: none !important;"></div>
                <div style="height:30px;">
                    <div class="copiedsuccess">UTM tracking code copied to clipboard</div>
                </div>
            </div>
        </form>
        <div class="column-flex">
            <div class="char-title">Total UTM Created</div>
            <p><?php echo $total_utm; ?></p>
        </div>
    </div>

    <div class="export_block">
        <p>Leads Details</p>
        <hr>
    </div>

    <div class="table100 ver3 m-b-110 table100-body js-pscroll ps ps--active-y" style="margin: 30px;">
        <table id="<?php echo $utm_table_name; ?>" class="filter_table">
            <thead>
            <tr class="row100 head">
                <?php
                $i = 1;
                foreach ($curr_table_schema as $head) {
                    ?>
                    <th class="cell100 <?php //echo $i; ?>"><?php echo $head['Field']; ?></th>
                    <?php $i++;
                } ?>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($curr_table as $row) { ?>
                <tr class="row100 body">
                    <?php
                    $i = 1;
                    foreach ($row as $item) { ?>
                        <td class="cell100 <?php //echo $i; ?>"><?php echo $item; ?></td>
                        <?php $i++;
                    } ?>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<!---->

<script>
    //Swich tabs
    function openTab(evt, cityName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    }

    //Swich tabs
    function openTabInner(evt, cityName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontentinner");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinksinner");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    }

    function isUrlValid(userInput) {
        var res = userInput.match(/(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/g);
        if (res == null)
            return false;
        else
            return true;
    }

    //Build UTM url
    function BuildUTM() {
        var site = jQuery("#website").val();
        if (isUrlValid(site)) {
            var utm = '';
            if (site.length != 0) {
                utm = site;
                var utm_src = [];
                var campaignSource = jQuery("#campaignSource").val();
                if (campaignSource.length != 0) {
                    utm_src.push("utm_source=" + campaignSource);
                }
                var campaignMedium = jQuery("#campaignMedium").val();
                if (campaignMedium.length != 0) {
                    utm_src.push("utm_medium=" + campaignMedium);
                }
                var campaignName = jQuery("#campaignName").val();
                if (campaignName.length != 0) {
                    utm_src.push("utm_campaign=" + campaignName);
                }
                var campaignTerm = jQuery("#campaignTerm").val();
                if (campaignTerm.length != 0) {
                    utm_src.push("utm_term=" + campaignTerm);
                }
                var campaignContent = jQuery("#campaignContent").val();
                if (campaignContent.length != 0) {
                    utm_src.push("utm_content=" + campaignContent);
                }

                utm = utm + "?" + utm_src.join('&');
                jQuery("#generatedUrl").val(utm);
                jQuery(".copiedsuccess").fadeOut();

                var action = "write_utm";
                var user = "<?php echo get_current_user_id();?>";
                var nonce = "<?php echo wp_create_nonce('create_utm'); ?>";
                jQuery.getJSON(ajaxurl, 'action=' + action + '&user=' + user + '&source=' + campaignSource + '&medium=' + campaignMedium + '&name=' + campaignName + '&term=' + campaignTerm + '&content=' + campaignContent + '&url=' + utm + '&nonce=' + nonce, function (resp) {
                });
            }
        } else {
            jQuery("#website").addClass("error");
        }
    }

    //Clear UTM
    function clearUTM() {
        jQuery("#utm_builder .form-group input").val("");
        jQuery("#generatedUrl").val("");
    }

    function copy(selector) {
        var $temp = jQuery("<div>");
        jQuery("body").append($temp);
        $temp.attr("contenteditable", true)
            .html(jQuery(selector).val()).select()
            .on("focus", function () {
                document.execCommand('selectAll', false, null)
            })
            .focus();
        document.execCommand("copy");
        $temp.remove();
        jQuery(".copiedsuccess").fadeIn();
    }
</script>

<script>
    var enumerateDaysBetweenDates = function (startDate, endDate) {
        var dates = [];

        var currDate = moment(startDate).startOf('day');
        var lastDate = moment(endDate).startOf('day');

        do {
            dates.push(currDate.format("D"));
        } while (currDate.add(1, 'days').diff(lastDate) < 0);

        return dates;
    };

    //Create random rgb color
    function random_rgb(basic_r, basic_g, basic_b, limit) {
        var o = Math.round, r = Math.random, s = limit;
        return 'rgba(' + o(r() * s + basic_r) + ',' + o(r() * s + basic_g) + ',' + o(r() * s + basic_b) + ')';
    }

    jQuery('.js-pscroll').each(function () {
        var ps = new PerfectScrollbar(this);

        jQuery(window).on('resize', function () {
            ps.update();
        })
    });

    jQuery('.filter_table').each(function () {
        var iter = 0;
        var show = false;
        var filtersConfig = new Object();
        filtersConfig['base_path'] = '<?php echo plugin_dir_url(__FILE__);?>assets/css/';
        jQuery(this).find('.head th').each(function () {
            if (jQuery(this).text() == 'utm_source' || jQuery(this).text() == 'utm_medium' || jQuery(this).text() == 'utm_campaign' || jQuery(this).text() == 'utm_term' || jQuery(this).text() == 'utm_content') {
                filtersConfig['col_' + iter] = 'select';
                show = true;
            } else {
                filtersConfig['col_' + iter] = 'none';
            }
            iter = iter + 1;
        });

        if (show) {
            var tf = new TableFilter(jQuery(this).attr('id'), filtersConfig);
            tf.init();
        }
    });
    jQuery('#wp_utm_builder').each(function () {
        var iter = 0;
        var show = false;
        var filtersConfig = new Object();
        filtersConfig['base_path'] = 'tablefilter/';
        jQuery(this).find('.head th').each(function () {
            if (jQuery(this).text() == 'source' || jQuery(this).text() == 'medium' || jQuery(this).text() == 'url' || jQuery(this).text() == 'date') {
                filtersConfig['col_' + iter] = 'select';
                show = true;
            } else {
                filtersConfig['col_' + iter] = 'none';
            }
            iter = iter + 1;
        });

        if (show) {
            var tf = new TableFilter(jQuery(this).attr('id'), filtersConfig);
            tf.init();
        }
    });


    jQuery('#pie_all, #pie_med_all').each(function () {
        var source_arr = jQuery(this).data('source');

        var source_data = [];
        var source_labels = [];
        var source_color = [];

        for (var k in source_arr) {
            if (source_arr.hasOwnProperty(k)) {
                source_data.push(source_arr[k]);
                source_labels.push(k);
                source_color.push(random_rgb(50, 150, 250, 100));
            }
        }

        var ctx = document.getElementById(jQuery(this).attr('id')).getContext('2d');
        // And for a doughnut chart
        var myDoughnutChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: source_labels,
                datasets: [{
                    label: '# of Votes',
                    data: source_data,
                    backgroundColor: source_color,
                    borderColor: source_color,
                    borderWidth: 1
                }]
            },
            options: {}
        });

    });

    jQuery('.pie_source, .pie_medium').each(function () {
        var source_arr = jQuery(this).data('source');
        var source_data = [];
        var source_labels = [];
        var source_color = [];
        source_arr.forEach(function (element) {
            if (element.utm_source != undefined) {
                source_data.push(element.count);
                source_labels.push(element.utm_source);
                source_color.push(random_rgb(50, 150, 250, 100));
            }
        });
        var ctx = document.getElementById(jQuery(this).attr('id')).getContext('2d');
        // And for a doughnut chart
        var myDoughnutChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: source_labels,
                datasets: [{
                    label: '# of Votes',
                    data: source_data,
                    backgroundColor: source_color,
                    borderColor: source_color,
                    borderWidth: 1
                }]
            },
            options: {}
        });

    });

    var day = new Date();
    var current_day = day.getDay();
    var date_labels = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
    var labels = enumerateDaysBetweenDates("<?php echo $startdate_line->format("Y-m-d");?>", "<?php echo $enddate_line->format("Y-m-d");?>");

    <?php
    echo "var source_data = " . json_encode($leads) . ';';
    echo "var medium_data = " . json_encode($leads_medium) . ';';
    ?>

    var source_data_sets = [];
    for (var prop in source_data) {
        var dataset = {};
        dataset.label = prop;
        dataset.borderColor = random_rgb(50, 150, 250, 100);
        dataset.pointBorderColor = random_rgb(50, 150, 250, 100);
        dataset.pointBackgroundColor = random_rgb(50, 150, 250, 100);
        dataset.pointHoverBackgroundColor = random_rgb(50, 150, 250, 100);
        dataset.pointHoverBorderColor = random_rgb(50, 150, 250, 100);
        dataset.pointBorderWidth = 5;
        dataset.pointHoverRadius = 5;
        dataset.pointHoverBorderWidth = 1;
        dataset.pointRadius = 1;
        dataset.fill = false;
        dataset.borderWidth = 4;
        dataset.data = Object.values(source_data[prop])

        source_data_sets.push(dataset);
    }
    var medium_data_sets = [];
    for (var prop in medium_data) {
        var dataset = {};
        dataset.label = prop;
        dataset.borderColor = random_rgb(50, 150, 250, 150);
        dataset.pointBorderColor = random_rgb(50, 150, 250, 150);
        dataset.pointBackgroundColor = random_rgb(50, 150, 250, 150);
        dataset.pointHoverBackgroundColor = random_rgb(50, 150, 250, 150);
        dataset.pointHoverBorderColor = random_rgb(50, 150, 250, 150);
        dataset.pointBorderWidth = 10;
        dataset.pointHoverRadius = 10;
        dataset.pointHoverBorderWidth = 1;
        dataset.pointRadius = 3;
        dataset.fill = false;
        dataset.borderWidth = 4;
        dataset.data = Object.values(medium_data[prop])

        medium_data_sets.push(dataset);
    }

    var ctx = document.getElementById('line_canvas').getContext("2d");
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: source_data_sets
        },
        options: {
            maintainAspectRatio: false,
            legend: {
                position: "bottom"
            },
            scales: {
                yAxes: [{
                    ticks: {
                        fontColor: "rgba(0,0,0,0.5)",
                        fontStyle: "bold",
                        beginAtZero: true,
                        maxTicksLimit: 5,
                        padding: 20
                    },
                    gridLines: {
                        drawTicks: false,
                        display: false
                    }

                }],
                xAxes: [{
                    gridLines: {
                        zeroLineColor: "transparent"
                    },
                    ticks: {
                        padding: 20,
                        fontColor: "rgba(0,0,0,0.5)",
                        fontStyle: "bold"
                    }
                }]
            }
        }
    });

    var ctx_medium = document.getElementById('line_canvas_medium').getContext("2d");
    var myChartMedium = new Chart(ctx_medium, {
        type: 'line',
        data: {
            labels: labels,
            datasets: medium_data_sets
        },
        options: {
            maintainAspectRatio: false,
            legend: {
                position: "bottom"
            },
            scales: {
                yAxes: [{
                    ticks: {
                        fontColor: "rgba(0,0,0,0.5)",
                        fontStyle: "bold",
                        beginAtZero: true,
                        maxTicksLimit: 5,
                        padding: 20
                    },
                    gridLines: {
                        drawTicks: false,
                        display: false
                    }

                }],
                xAxes: [{
                    gridLines: {
                        zeroLineColor: "transparent"
                    },
                    ticks: {
                        padding: 20,
                        fontColor: "rgba(0,0,0,0.5)",
                        fontStyle: "bold"
                    }
                }]
            }
        }
    });

    //Initiate daterangepicker
    jQuery(function () {
        <?php if(isset($_GET["start"]) && isset($_GET["end"])){?>
        var start = moment("<?php echo sanitize_text_field($_GET["start"]);?>");
        var end = moment("<?php echo sanitize_text_field($_GET["end"]);?>");
        <?php }
        else{ ?>
        var start = moment().subtract(6, 'days');
        var end = moment();
        <?php    }?>

        function cb(start, end) {
            jQuery('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }

        jQuery('#reportrange').daterangepicker({
            startDate: start,
            endDate: end
        }, cb);

        cb(start, end);

        jQuery('#reportrange').on('apply.daterangepicker', function (ev, picker) {
            var url = window.location.href;
            if (url.indexOf("&start=") != -1) {
                url = url.substr(0, url.indexOf("&start="));
            }
            url = url + "&start=" + picker.startDate.format('YYYY-M-D') + "&end=" + picker.endDate.format('YYYY-M-D');
            window.location.href = url;
        });
    });

    jQuery(".filters .dates").on("click", function () {
        var days = jQuery(this).data("time");
        var start = moment().subtract(days, 'days');
        var end = moment();
        var url = window.location.href;
        if (url.indexOf("&start=") != -1) {
            url = url.substr(0, url.indexOf("&start="));
        }
        if (days != -1) {
            url = url + "&start=" + start.format('YYYY-M-D') + "&end=" + end.format('YYYY-M-D');
        }
        window.location.href = url;
    });

    //Download table as CSV
    function download_csv(csv, filename) {
        var csvFile;
        var downloadLink;

        // CSV FILE
        csvFile = new Blob([csv], {type: "text/csv"});

        // Download link
        downloadLink = document.createElement("a");

        // File name
        downloadLink.download = filename;

        // We have to create a link to the file
        downloadLink.href = window.URL.createObjectURL(csvFile);

        // Make sure that the link is not displayed
        downloadLink.style.display = "none";

        // Add the link to your DOM
        document.body.appendChild(downloadLink);

        // Lanzamos
        downloadLink.click();
    }

    //Export table as CSV
    function export_table_to_csv(html, filename) {
        var csv = [];
        var rows = document.querySelectorAll("table.table_to_export tr:not(.fltrow)");

        for (var i = 0; i < rows.length; i++) {
            var row = [], cols = rows[i].querySelectorAll("td, th");

            for (var j = 0; j < cols.length; j++)
                row.push(cols[j].innerText);

            csv.push(row.join(","));
        }

        // Download CSV
        download_csv(csv.join("\n"), filename);
    }

    document.getElementById("export_to_csv").addEventListener("click", function () {
        var html = document.getElementsByClassName("table_to_export").outerHTML;
        export_table_to_csv(html, "table.csv");
    });

</script>