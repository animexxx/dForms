<?php
//check permission
if (!current_user_can('manage_options')) {
    wp_die(__('You do not have sufficient permissions to access this page.'));
}
?>
<div id="dForm">
    <div id="leftPanel">
        <div>
            <h3>Form Tools</h3>
            <ul id="dform_tools">
                <li>
                    <a href="javascript:void(0)" id="dForm-heading">Heading</a>
                </li>
                <li>
                    <a href="javascript:void(0)" id="dForm-textbox">Text Box</a>
                </li>
                <li>
                    <a href="javascript:void(0)" id="dForm-textarea">Text Area</a>
                </li>
                <li>
                    <a href="javascript:void(0)" id="dForm-dropdown">Drop Down</a>
                </li>
                <li>
                    <a href="javascript:void(0)" id="dForm-radio">Radio Button</a>
                </li>
                <li>
                    <a href="javascript:void(0)" id="dForm-checkbox">Check Box</a>
                </li>
                <li>
                    <a href="javascript:void(0)" id="dForm-matrix">Matrix</a>
                </li>
                <li>
                    <a href="javascript:void(0)" id="dForm-submit">Submit Button</a>
                </li>
            </ul>
        </div>
    </div><!--leftPanel-->

    <div id="rightPanel">
        <div>

            <?php
            if (isset($_GET['formId'])):
            $postObject = get_post($_GET['formId']);
            $postContent = $postObject->post_content;
            ?>
            <h3>
                <div class="able_edit"><?php echo $postObject->post_title ?></div>
            </h3>
            <a id="UpdateDForm" href="javascript:void(0)">Update</a>
            <input type="hidden" id="postID" value="<?php echo $_GET['formId'] ?>"/>
            <a id="closeDForm" href="admin.php?page=dForm-x">Close</a>
            <div id="your_dForm">

                <?php
                echo urldecode($postContent);
                else:
                ?>
                <h3>
                    <div class="able_edit">Your Form</div>
                </h3>
                <a id="saveDForm" href="javascript:void(0)">Save</a>
                <a id="closeDForm" href="admin.php?page=dForm-x">Close</a>
                <input type="hidden" id="name_input" value="0"/>
                <div id="your_dForm">
                    <form action="" method="post" id="your_dForm_form">
                        <input type="hidden" id="name_input" value="0"/>
                        <div class="dForm_Heading dFormElement">
                            <div>
                                <h1>
                                    <div class="able_edit">Click to edit this text</div>
                                </h1>
                                <a class="remove_element" href="javascript:void(0)">Remove</a>
                            </div>
                        </div>
                        <div class="dForm_textbox dFormElement">
                            <div>
                                <label class="lef_label">
                                    <div class="able_edit">Click to edit</div>
                                </label>
                                <div><input type="text" value="" name="textbox_0" class="input_element"/></div>
                                <a class="option_element" href="javascript:void(0)">Option</a>
                                <div class="option_popup">
                                    <table>
                                        <tr>
                                            <td>Require *</td>
                                            <td><input type="checkbox" value="1" class="requiteField" name="requite_x"/>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <a class="remove_element" href="javascript:void(0)">Remove</a>

                            </div>
                        </div>
                        <div class="dForm_submit dFormElement">
                            <div>
                                <div><input type="submit" value="Submit"/></div>
                                <a class="option_element" href="javascript:void(0)">Option</a>
                                <div class="option_popup">
                                    <table>
                                        <tr>
                                            <td>Data :</td>
                                            <td><textarea class="data_op">Submit</textarea></td>
                                        </tr>
                                    </table>
                                </div>
                                <a class="remove_element" href="javascript:void(0)">Remove</a>
                            </div>
                        </div>


                    </form>
                    <?php
                    endif;
                    ?>

                </div><!--your_dForm-->

            </div>
        </div><!--rightPanel-->

        <div id="dForm_lib">


            <!--dForm_Heading-->
            <div class="dForm_Heading dFormElement">
                <div>
                    <h1>
                        <div class="able_edit">Click to edit this text</div>
                    </h1>
                    <a class="remove_element" href="javascript:void(0)">Remove</a>
                </div>
            </div>
            <!--dForm_Heading-->

            <!--dForm_textbox-->
            <div class="dForm_textbox dFormElement">
                <div>
                    <label class="lef_label">
                        <div class="able_edit">Click to edit</div>
                    </label>
                    <div><input type="text" value="" name="textbox_x" class="input_element"/></div>
                    <a class="option_element" href="javascript:void(0)">Option</a>
                    <div class="option_popup">
                        <table>
                            <tr>
                                <td>Require *</td>
                                <td><input type="checkbox" value="1" class="requiteField" name="requite_x"/></td>
                            </tr>
                        </table>
                    </div>
                    <a class="remove_element" href="javascript:void(0)">Remove</a>
                </div>
            </div>
            <!--dForm_textbox-->


            <!--dForm_textarea-->
            <div class="dForm_textarea dFormElement">
                <div>
                    <label class="lef_label">
                        <div class="able_edit">Click to edit</div>
                    </label>
                    <div><textarea class="input_element" name="textarea_x"></textarea></div>
                    <a class="option_element" href="javascript:void(0)">Option</a>
                    <div class="option_popup">
                        <table>
                            <tr>
                                <td>Require *</td>
                                <td><input type="checkbox" value="1" class="requiteField" name="requite_x"/></td>
                            </tr>
                        </table>
                    </div>
                    <a class="remove_element" href="javascript:void(0)">Remove</a>
                </div>
            </div>
            <!--dForm_textarea-->


            <!--dForm_dropdown-->
            <div class="dForm_dropdown dFormElement">
                <div>
                    <label class="lef_label">
                        <div class="able_edit">Click to edit</div>
                    </label>
                    <div><select name="select_x" class="input_element">
                            <option></option>
                            <option value="Option 1">Option 1</option>
                            <option value="Option 2">Option 2</option>
                            <option value="Option 3">Option 3</option>
                        </select></div>
                    <a class="option_element" href="javascript:void(0)">Option</a>
                    <div class="option_popup">
                        <table>
                            <tr>
                                <td>Require *</td>
                                <td><input type="checkbox" value="1" class="requiteField" name="requite_x"/></td>
                            </tr>
                            <tr>
                                <td>Data :</td>
                                <td>
									<textarea class="data_op">Option 1
Option 2
Option 3
									</textarea></td>
                            </tr>
                        </table>
                    </div>
                    <a class="remove_element" href="javascript:void(0)">Remove</a>
                </div>
            </div>
            <!--dForm_dropdown-->


            <!--dForm_radio-->
            <div class="dForm_radio dFormElement">
                <div>
                    <label class="lef_label">
                        <div class="able_edit">Click to edit</div>
                    </label>
                    <div>
                        <ul>
                            <li><input type="radio" name="radio_x" value="1" class="input_element"/>Option 1</li>
                            <li><input type="radio" name="radio_x" value="2" class="input_element"/>Option 2</li>
                            <li><input type="radio" name="radio_x" value="3" class="input_element"/>Option 3</li>
                        </ul>
                    </div>
                    <a class="option_element" href="javascript:void(0)">Option</a>
                    <div class="option_popup">
                        <table>
                            <tr>
                                <td>Require *</td>
                                <td><input type="checkbox" value="1" class="requiteField" name="requite_x"/></td>
                            </tr>
                            <tr>
                                <td>Other Value</td>
                                <td><input type="checkbox" value="1" class="otherValue"/></td>
                            </tr>
                            <tr>
                                <td>Data :</td>
                                <td><textarea class="data_op">Option 1
Option 2
Option 3
									</textarea></td>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <a class="remove_element" href="javascript:void(0)">Remove</a>
                </div>
            </div>
            <!--dForm_radio-->


            <!--dForm_checkbox-->
            <div class="dForm_checkbox dFormElement">
                <div>
                    <label class="lef_label">
                        <div class="able_edit">Click to edit</div>
                    </label>
                    <div>
                        <ul>
                            <li><input type="checkbox" name="checkbox_x" value="1" class="input_element"/>Option 1</li>
                            <li><input type="checkbox" name="checkbox_x" value="2" class="input_element"/>Option 2</li>
                            <li><input type="checkbox" name="checkbox_x" value="3" class="input_element"/>Option 3</li>
                        </ul>
                    </div>
                    <a class="option_element" href="javascript:void(0)">Option</a>
                    <div class="option_popup">
                        <table>
                            <tr>
                                <td>Require *</td>
                                <td><input type="checkbox" value="1" class="requiteField" name="requite_x"/></td>
                            </tr>
                            <tr>
                                <td>Data :</td>
                                <td><textarea class="data_op">Option 1
Option 2
Option 3
									</textarea></td>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <a class="remove_element" href="javascript:void(0)">Remove</a>
                </div>
            </div>
            <!--dForm_checkbox-->


            <!--dForm_submit-->
            <div class="dForm_submit dFormElement">
                <div>
                    <div><input type="submit" value="Submit"/></div>
                    <a class="option_element" href="javascript:void(0)">Option</a>
                    <div class="option_popup">
                        <table>
                            <tr>
                                <td>Data :</td>
                                <td><textarea class="data_op">Submit</textarea></td>
                            </tr>
                        </table>
                    </div>
                    <a class="remove_element" href="javascript:void(0)">Remove</a>
                </div>
            </div>
            <!--dForm_submit-->

            <!--dForm_matrix-->
            <div class="dForm_matrix dFormElement">
                <div>
                    <label class="lef_label matrix_l" style="float: none">
                        <div class="able_edit">Click to edit</div>
                    </label>
                    <table cellspacing="0" cellpadding="4" width="60%" class="dataMatrix">
                        <tr>
                            <th style="border:none">&nbsp;</th>
                            <th style="width:27%">Very 1</th>
                            <th style="width:27%">Very 2</th>
                            <th style="width:27%">Very 3</th>
                        </tr>
                        <tr>
                            <th align="left">Option 1</th>
                            <td align="center">
                                <input type="checkbox" value="Very 1" name="0_matrix_0[]">
                            </td>
                            <td align="center">
                                <input type="checkbox" value="Very 2" name="0_matrix_0[]">
                            </td>
                            <td align="center">
                                <input type="checkbox" value="Very 3" name="0_matrix_0[]">
                            </td>
                        </tr>
                        <tr>
                            <th align="left">Option 2</th>
                            <td align="center">
                                <input type="checkbox" value="Very 1" name="1_matrix_0[]">
                            </td>
                            <td align="center">
                                <input type="checkbox" value="Very 2" name="1_matrix_0[]">
                            </td>
                            <td align="center">
                                <input type="checkbox" value="Very 3" name="1_matrix_0[]">
                            </td>
                        </tr>
                        <tr>
                            <th align="left">Option 3</th>
                            <td align="center">
                                <input type="checkbox" value="Very 1" name="2_matrix_0[]">
                            </td>
                            <td align="center">
                                <input type="checkbox" value="Very 2" name="2_matrix_0[]">
                            </td>
                            <td align="center">
                                <input type="checkbox" value="Very 3" name="2_matrix_0[]">
                            </td>
                        </tr>
                    </table>

                    <a class="option_element" href="javascript:void(0)">Option</a>
                    <div class="option_popup">
                        <table>
                            <tr>
                                <td>Radio choice</td>
                                <td><input type="checkbox" class="radio_choice"/></td>
                            </tr>
                            <tr>
                                <td>Data Rows:</td>
                                <td><textarea class="data_op data_rows">Very 1
Very 2
Very 3
									</textarea></td>
                            </tr>
                            <tr>
                                <td>Data Columns:</td>
                                <td><textarea class="data_op data_columns">Option 1
Option 2
Option 3</textarea></td>
                            </tr>

                        </table>
                    </div>
                    <a class="remove_element" href="javascript:void(0)">Remove</a>
                </div>
            </div>
            <!--dForm_matrix-->

        </div><!--dForm_lib-->
        <div style="clear: both"></div>
    </div><!--dForm-->