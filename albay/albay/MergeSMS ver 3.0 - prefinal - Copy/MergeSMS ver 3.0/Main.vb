Public Class Main




    Private Property myaccount_ip
    Private Property total_inserted As Integer

    Private Property total_row As Object

    Private Property num_limit As Integer

    Private senderadress As String


    Private identify As Boolean


    Dim q As New connection_data_thread

    Dim bg_cancel As Integer = 0

    Private Sub BW_trigger_work(sender As Object, e As System.ComponentModel.DoWorkEventArgs) Handles BW_trigger.DoWork


        'Try

        'Catch ex As Exception

        'End Try


        'Dim oProcess As New Process()
        'Dim oStartInfo As New ProcessStartInfo("cmd.exe", "/c adb -s " + myaccount_ip + ":5555 logcat -b events")
        'oStartInfo.UseShellExecute = False
        'oStartInfo.RedirectStandardOutput = True
        'oStartInfo.WindowStyle = ProcessWindowStyle.Hidden
        'oStartInfo.CreateNoWindow = True
        'oProcess.StartInfo = oStartInfo

        'Try
        '    oProcess.Start()




        '    'adb logcat -b radio


        '    Dim sOutput As String
        '    Dim oStreamReader As System.IO.StreamReader = oProcess.StandardOutput

        '    While Not oStreamReader.EndOfStream
        '        If BW_trigger.CancellationPending Then
        '            Exit Sub
        '        End If

        '        Dim strToRead = oStreamReader.ReadLine

        '        Console.WriteLine(strToRead)

        '        BW_trigger.ReportProgress(3, strToRead)

        '        If strToRead.Contains("notification_enqueue") Then


        '            'Console.WriteLine(strToRead)


        '            If Not BackgroundWorker1.IsBusy Then

        '                BW_trigger.ReportProgress(2, 1)

        '                BackgroundWorker1.RunWorkerAsync()

        '            End If

        '        End If

        '    End While

        'Catch ex As Exception

        '    BW_trigger.ReportProgress(3,"Error connection to " + myaccount_ip)

        'End Try

        If Not BackgroundWorker1.IsBusy Then

            BW_trigger.ReportProgress(2, 1)

            'BackgroundWorker1.RunWorkerAsync()

        End If

    End Sub

    Private Sub BackgroundWorker1_ProgressChanged(sender As Object, e As System.ComponentModel.ProgressChangedEventArgs) Handles BackgroundWorker1.ProgressChanged

        ProgressBar1.Value = e.ProgressPercentage

        txt_homelogs.AppendText(e.UserState.ToString + Environment.NewLine)

        Select Case (e.ProgressPercentage * 100) Mod 3

            Case 1
                Pnl_light1.BackColor = Color.Red
                pnl_light3.BackColor = Color.Black
                pnl_light4.BackColor = Color.Black
            Case 2
                Pnl_light1.BackColor = Color.Black
                pnl_light3.BackColor = Color.Red
                pnl_light4.BackColor = Color.Black
            Case Else

                Pnl_light1.BackColor = Color.Black
                pnl_light3.BackColor = Color.Black
                pnl_light4.BackColor = Color.Red


        End Select


    End Sub


    Private Sub BackgroundWorker1_RunWorkerCompleted(sender As Object, e As System.ComponentModel.RunWorkerCompletedEventArgs) Handles BackgroundWorker1.RunWorkerCompleted

        ' Console.WriteLine("synced")
        '  Shell("adb -s " + myaccount_ip + ":5555 logcat -b events -c", AppWinStyle.Hide, True)
        'pb_progressSync.Value = 0.0

        txt_homelogs.AppendText("Sync Finished..")


    End Sub

    Private Sub BackgroundWorker1_DoWork(sender As Object, e As System.ComponentModel.DoWorkEventArgs) Handles BackgroundWorker1.DoWork

        '   Console.WriteLine("Thread on synced........................................")


        'lbl_progress.Text = "Device connected: " + myaccount_ip
        'lbl_progress.ForeColor = Color.Green



        '        If phoneType = "1" Then

        '   Shell("adb -s " + myaccount_ip + ":5555 pull /data/data/com.android.providers.telephony/databases/mmssms.db " + sqlite_db_path.ToString, AppWinStyle.Hide, True)
        '    Shell("adb -s " + myaccount_ip + ":5555 pull /data/data/com.android.providers.telephony/databases/mmssms.db-wal " + sqlite_db_path.ToString, AppWinStyle.Hide, True)
        ' Else

        '???????????????????????????????????????????????


        '  If phoneType = "1" Then
        'Shell("adb -s " + myaccount_ip + ":5555 pull /data/data/com.android.providers.telephony/databases/mmssms.db-wal " + sqlite_db_path.ToString + "mmssms.db-wal", AppWinStyle.Hide, True)

        ' Shell("adb -s " + myaccount_ip + ":5555 pull /data/data/com.android.providers.telephony/databases/mmssms.db " + sqlite_db_path.ToString + "mmssms.db", AppWinStyle.Hide, True)
        'Else

        '   Shell("adb -s " + myaccount_ip + ":5555 shell su -c 'chmod 777 /data/data/com.android.providers.telephony/databases/mmssms.db'", AppWinStyle.Hide, True)
        '  Shell("adb -s " + myaccount_ip + ":5555 shell su -c 'cp /data/data/com.android.providers.telephony/databases/mmssms.db /sdcard/mmssms.db'", AppWinStyle.Hide, True)
        ' Shell("adb -s " + myaccount_ip + ":5555 pull /sdcard/mmssms.db " + sqlite_db_path.ToString + "mmssms.db", AppWinStyle.Hide, True)
        '//////////////////////////////////////

        'End If

        'latest pull message!!!!!!!!!!!!!!!!111

        'Shell("adb -s " + myaccount_ip + ":5555 shell su -c 'chmod 777 /data/data/com.android.providers.telephony/databases/mmssms.db'", AppWinStyle.Hide, True)
        'Shell("adb -s " + myaccount_ip + ":5555 shell su -c 'cp /data/data/com.android.providers.telephony/databases/mmssms.db /sdcard/mmssms.db'", AppWinStyle.Hide, True)
        'Shell("adb -s " + myaccount_ip + ":5555 pull /sdcard/mmssms.db " + sqlite_db_path.ToString + "mmssms.db", AppWinStyle.Hide, True)
        '//////////////////////////////////////


        'Shell("adb -s " + myaccount_ip + ":5555 shell su -c 'chmod 777 /data/data/com.android.providers.telephony/databases/mmssms.db'", AppWinStyle.Hide, True)
        'Shell("adb -s " + myaccount_ip + ":5555 pull /data/data/com.android.providers.telephony/databases/mmssms.db " + sqlite_db_path.ToString, AppWinStyle.Hide, True)



        '  End If

        '

        'Shell("adb -s " + myaccount_ip + ":5555 pull /data/data/com.android.providers.telephony/databases/mmssms.db-wal c:\MergePoint\mmssms.db-wal", AppWinStyle.Hide, True)




        total_inserted = 0

        Dim klll = ""

        Dim config_type = k_thread.Query_thread("select * from config_sm_type").Tables(0)
        Dim config = k_thread.Query_thread("select * from config_sm").Tables(0)

        total_row = k_thread.Query_thread("select body from sms where address='" + senderadress + "' limit " + num_limit.ToString + ";").Tables(0).Rows.Count

        Dim count_row = 0
        For Each sms_row In k_thread.Query_thread("select body,from_unixtime(date / 1000,'%Y-%m-%d %H:%i:%s') as date,address from sms where address='" + senderadress + "' order by date desc limit " + num_limit.ToString + ";").Tables(0).Rows



            If BackgroundWorker1.CancellationPending = True Then

                e.Cancel = True
                BackgroundWorker1.ReportProgress(1)

                Exit Sub

            End If

            Dim body = sms_row(0).ToString.Split(" ")



            'loop through configs from db

            For Each row_config_type In config_type.Rows



                Dim check As Boolean = True
                Dim stats = row_config_type(3).ToString


                Dim stat_value As New ArrayList
                Dim stat_index As New ArrayList
                Dim nonstat_value As New ArrayList
                Dim nonstat_index As New ArrayList
                Dim nonstat_type As New ArrayList
                'stat_value.Clear()
                'stat_index.Clear()
                'nonstat_value.Clear()
                'nonstat_index.Clear()
                'nonstat_type.Clear()
                'additional array list for outgoing
                Dim outgoing_col As New ArrayList
                Dim outgoing_val As New ArrayList




                Dim x = row_config_type(0).ToString

                For Each row_config In config.Select("static=1 and config_sm_type_no=" + row_config_type(0).ToString)

                    stat_value.Add(row_config(2).ToString)
                    stat_index.Add(CInt(row_config(1)))

                Next

                For Each row_config In config.Select("static=0 and config_sm_type_no=" + row_config_type(0).ToString)

                    nonstat_value.Add(row_config(2))
                    nonstat_index.Add(row_config(1))
                    nonstat_type.Add(row_config(5))
                    'MessageBox.Show(row_config(1).ToString)

                Next



                For i As Integer = 0 To stat_value.ToArray.Length - 1


                    Try

                        If Not body(stat_index.Item(i)).Equals(stat_value.Item(i).ToString) Then

                            check = False
                            Exit For
                        Else


                        End If

                    Catch ex As Exception

                        '  Console.WriteLine("Synced error")
                        check = False
                        Exit For

                    End Try




                Next

           




                ''''part of inserting sms filtered
                If check Then
                    Dim ref_check As String = ""
                    Dim str_values = "("
                    For i As Integer = 0 To nonstat_index.ToArray.Length - 1
                        Try
                            If nonstat_type.Item(i).Equals("datetime") Then
                                body(nonstat_index.Item(i)) = sms_row(1).ToString
                            End If

                            If nonstat_value.Item(i).Equals("ref_no") Then
                                ref_check = body(nonstat_index.Item(i)).Replace("Ref:", "").Replace("RRN:", "")
                            End If

                            str_values = str_values + autoconvert(body(nonstat_index.Item(i)), nonstat_type.Item(i), nonstat_value(i).ToString)

                            If Not i = (nonstat_index.ToArray.Length - 1) Then
                                str_values = str_values + ","
                            End If

                        Catch ex As Exception
                            Continue For
                        End Try

                    Next

                    If reference_exist(ref_check, stats) Then
                        Continue For
                    End If
                    'this area is for checking of outgoing incoming charges
                    Dim service_charge = "0.00", network_charge = "102", cash_amount = "0.00"

                    If stats.Equals("3") Then

                        Dim account = body(nonstat_index(nonstat_value.IndexOf("account"))).Replace(".", "").ToUpper.ToString
                        Dim amt = toMoney(body(nonstat_index(nonstat_value.IndexOf("amount"))))

                        service_charge = getServiceCahrge(account, amt, 0)

                        network_charge = getNetworkChargeId(amt)

                        Dim net_chrge = getNetworkCharge(amt)



                        'updated for padala automatic charge

                        cash_amount = Format(CDec(amt) + CDec(service_charge), "0.00").ToString


                        ' str_values = str_values + "," + stats + ")"

                    End If

                    str_values = str_values + "," + service_charge + "," + network_charge + "," + cash_amount + ", " + stats + ",'" + sms_row(0).ToString + "')"

                    klll = "Insert into transaction_sm(" + String.Join(",", nonstat_value.ToArray).ToString + ",service_charge,network_charge_no,cash_amount,status,body_sms) values " + str_values

                    If klll.Contains("557751******9104") Then
                        'Console.WriteLine("Insert into transaction_sm(" + String.Join(",", nonstat_value.ToArray).ToString + ",service_charge,network_charge_no,cash_amount,status,body_sms) values " + str_values)

                    End If

                    Try
                        If k_thread.NonQuery_thread("Insert into transaction_sm(" + String.Join(",", nonstat_value.ToArray).ToString + ",service_charge,network_charge_no,cash_amount,status,body_sms) values " + str_values) > 0 Then
                            total_inserted = total_inserted + 1
                        End If
                    Catch ex As Exception
                        '   Console.WriteLine("Error but continue")
                        Continue For
                    End Try

                    'Console.WriteLine("Insert into transaction_sm(" + String.Join(",", nonstat_value.ToArray).ToString + ",service_charge,network_charge_no,cash_amount,status,body_sms) values " + str_values)

                End If

            Next

            count_row = count_row + 1

            Dim reportArr = klll

            BackgroundWorker1.ReportProgress((count_row * 100) / total_row, reportArr.ToString)

        Next
    End Sub


    Private Function autoconvert(value As String, column As String, spec As String) As String



        If (spec.Equals("ref_no")) Then

            Return "'" + value.ToString.Replace("Ref:", "").Replace("RRN:", "") + "'"

        End If



        If (column = "double" Or column = "decimal") Then

            Return toMoney(value).ToString
        ElseIf column = "int" Then
            ' Console.WriteLine(toInteger(value).ToString)

            If spec.Equals("account") Then
                Dim row_id = k_thread.Query_thread("select account_no from account_sm where account_id='" + value.Replace(".", "").ToUpper + "' or name='" + value.Replace(".", "").ToUpper + "'").Tables(0).Rows

                Try

                    Return row_id(0)(0).ToString

                Catch ex As Exception

                    ' Console.WriteLine(spec + " --- " + column + " ----- " + value)
                    ' Throw New Exception("Error account name failed")
                End Try



            End If


            Return toInteger(value)


        Else

            Return "'" + value + "'"

        End If




    End Function
    Private Function reference_exist(ref As String, stats As String) As Boolean






        Try

            Dim str_add = ""

            If stats.Equals("3") Then
                str_add = str_add & " status = 3 and "

            ElseIf stats.Equals("1") Then
                str_add = str_add & " status in(1,2) and "

            End If




            Dim val = k_thread.Query("select count(tran_id) from transaction_sm  where " + str_add + " ref_no='" + ref + "'").Tables(0).Rows

            If val(0).Item(0) > 0 Then
                Return True
            End If

        Catch ex As Exception
            'Console.WriteLine(ref)
        End Try


        Return False


    End Function



    Private Sub runTrigger()

        If Not BW_trigger.IsBusy Then
            BW_trigger.RunWorkerAsync()
        End If



    End Sub
    Private Sub stopTrigger()
        BW_trigger.CancelAsync()
    End Sub

    Private Sub getStatus_sms()

       
    End Sub
    Private Sub Form1_Load(sender As Object, e As EventArgs) Handles Me.Load



        identify = True

        num_limit = 100

        initiate_connection()

        myaccount_ip = getPhoneIp()



        lbl_storename.Text = storename

        sm_ip.Text = myaccount_ip.ToString
        senderadress = sm_senderaddress.Text

        q.mysqlCon()
        temp_con.mysqlCon()
        'bgw_sendSms.RunWorkerAsync()

        Timer1.Start()



    End Sub

    Private Sub ChromeButton1_Click(sender As Object, e As EventArgs)

        runTrigger()


    End Sub

    Private Sub ChromeButton2_Click(sender As Object, e As EventArgs)
        stopTrigger()

    End Sub

    Private Sub BW_trigger_ProgressChanged(sender As Object, e As System.ComponentModel.ProgressChangedEventArgs) Handles BW_trigger.ProgressChanged

        Static light_num = 1



        If e.ProgressPercentage = 2 Then
            txt_logs.AppendText(Date.Now.ToString + ":  Message Received..." + Environment.NewLine)
        Else
            txt_homelogs.AppendText(e.UserState.ToString)


            Select Case light_num Mod 3

                Case 1
                    Pnl_light1.BackColor = Color.Red
                    pnl_light3.BackColor = Color.Black
                    pnl_light4.BackColor = Color.Black
                Case 2
                    Pnl_light1.BackColor = Color.Black
                    pnl_light3.BackColor = Color.Red
                    pnl_light4.BackColor = Color.Black
                Case Else

                    Pnl_light1.BackColor = Color.Black
                    pnl_light3.BackColor = Color.Black
                    pnl_light4.BackColor = Color.Red


            End Select

        End If


        light_num = light_num + 1
    End Sub

    Private Sub ChromeButton1_Click_1(sender As Object, e As EventArgs) Handles ChromeButton1.Click

        If Not BackgroundWorker1.IsBusy Then

            BackgroundWorker1.RunWorkerAsync()
        End If

    End Sub

    Private Sub ChromeButton2_Click_1(sender As Object, e As EventArgs) Handles ChromeButton2.Click

       

        txt_logs.AppendText(Date.Now.ToString + "This feature is deprecated" + Environment.NewLine)

    End Sub

    Private Sub ChromeButton3_Click(sender As Object, e As EventArgs) Handles ChromeButton3.Click

        If Not (BW_trigger.IsBusy) Then


            txt_logs.AppendText(Date.Now.ToString + " Trying to connect to " + myaccount_ip + Environment.NewLine)

            BW_trigger.Dispose()


            BW_trigger.RunWorkerAsync()


        End If


    End Sub

    Private Sub TabPage2_Click(sender As Object, e As EventArgs) Handles TabPage2.Click

    End Sub

    Private Sub ChromeButton7_Click(sender As Object, e As EventArgs) Handles ChromeButton7.Click

        txt_logs.Clear()


    End Sub

    Private Sub ChromeButton9_Click(sender As Object, e As EventArgs) Handles ChromeButton9.Click

        setPhoneIp(sm_ip.Text.ToString.Trim)

        myaccount_ip = getPhoneIp()


    End Sub

    Private Sub ChromeButton10_Click(sender As Object, e As EventArgs) Handles ChromeButton10.Click

        senderadress = sm_senderaddress.Text

    End Sub

    Private Sub ChromeButton11_Click(sender As Object, e As EventArgs) Handles btnSMSforward.Click

        If bg_cancel = 0 Then
            bg_cancel = 1
            btnSMSforward.Text = "Start forwarding SMS"
        Else
            'bgw_sendSms.RunWorkerAsync()
            bg_cancel = 0
            btnSMSforward.Text = "Stop forwarding SMS"
        End If

    End Sub

    Private Sub bgw_sendSms_DoWork(sender As Object, e As System.ComponentModel.DoWorkEventArgs) Handles bgw_sendSms.DoWork

        If bg_cancel = 1 Then

            e.Cancel = True

            Exit Sub

        End If

        Dim data = q.Query("Select * from sms_stack where status=0")

        If data.Tables(0).Rows.Count > 0 Then

            For i = 0 To data.Tables(0).Rows.Count - 1
                Dim content(2) As String
                Dim sms_no = data.Tables(0).Rows(i)("sms_no").ToString
                Dim sms_body = data.Tables(0).Rows(i)("sms_body").ToString
                Dim mobile_no = data.Tables(0).Rows(i)("mobile_no").ToString

                Try

                    Dim checkMobile = txtCheckMobile.Text.ToString.Trim

                    If (Not checkMobile = "") Then


                        sendMsg(sms_body, checkMobile)

                    End If

                    sendMsg(sms_body, mobile_no)



                    content(0) = sms_body
                    content(1) = mobile_no

                    bgw_sendSms.ReportProgress(0, content)

                    q.NonQuery("update sms_stack set status=1 where sms_no='" + sms_no.ToString + "'")

                Catch ex As Exception

                    q.NonQuery("update sms_stack set status=2 where sms_no='" + sms_no.ToString + "'")

                End Try
               
                Threading.Thread.Sleep(500)

            Next

        Else

            ' Console.WriteLine("No sms to forward")
        End If

    End Sub

    Private Sub frm_main_Click(sender As Object, e As EventArgs) Handles frm_main.Click

    End Sub

    Private Sub bgw_sendSms_ProgressChanged(sender As Object, e As System.ComponentModel.ProgressChangedEventArgs) Handles bgw_sendSms.ProgressChanged
        Dim content = e.UserState

        txtsendSmsLogs.AppendText(content(0).ToString & " is successfully forward to the contact no. " & content(1).ToString & " " & vbNewLine)

    End Sub

    Private Sub bgw_sendSms_RunWorkerCompleted(sender As Object, e As System.ComponentModel.RunWorkerCompletedEventArgs) Handles bgw_sendSms.RunWorkerCompleted

        If bg_cancel = 1 Then
            Exit Sub
        End If

        'bgw_sendSms.RunWorkerAsync()
      
    End Sub

    Private Sub ChromeButton11_Click_1(sender As Object, e As EventArgs) Handles ChromeButton11.Click

        If txtcontact.Text.Length > 0 Then

            If txtsmsbody.Text.Length > 0 Then

                Try
                    sendSms(txtsmsbody.Text.ToString, txtcontact.Text.ToString)
                    MessageBox.Show("Message Sent", "Sent", MessageBoxButtons.OK, MessageBoxIcon.Information)
                Catch ex As Exception
                    MessageBox.Show("Message Not Sent", "Not Sent", MessageBoxButtons.OK, MessageBoxIcon.Information)
                End Try

            Else

                ErrorProvider1.SetError(Me.txtsmsbody, "Plss. Input message")

            End If

            ErrorProvider1.SetError(Me.txtcontact, Nothing)

        Else
            ErrorProvider1.SetError(Me.txtcontact, "Plss. Input contact no")
        End If
        

    End Sub

    Private Sub dg_msgmenu_Click(sender As Object, e As EventArgs) Handles dg_msgmenu.Click

        If txt_name.Text = Nothing Then
            ErrorProvider1.SetError(Me.txt_name, "Plss. Input name")
        Else

            ErrorProvider1.SetError(Me.txt_name, Nothing)

            Dim arr = dg_msgmenu.Item(2, dg_msgmenu.CurrentCell.RowIndex).Value.ToString

            Dim frm As New frmfilter

            frm.smsBody = arr
            frm.sms_statusId = cbo_status.SelectedValue.ToString
            frm.filterName = txt_name.Text.ToString



            If Not arr = Nothing Then
                frm.ShowDialog()
            End If

        End If

       

    End Sub

    Private Sub dg_msgmenu_CellContentClick(sender As Object, e As DataGridViewCellEventArgs) Handles dg_msgmenu.CellContentClick

    End Sub

    Private Sub ChromeButton12_Click(sender As Object, e As EventArgs) Handles ChromeButton12.Click
        txtsendSmsLogs.Clear()
    End Sub

    Private Sub ChromeButton13_Click(sender As Object, e As EventArgs) Handles ChromeButton13.Click

        FolderBrowserDialog1.ShowDialog()

        Dim dbKey = txtFindDb.Text.ToString.Trim



        Dim str = FolderBrowserDialog1.SelectedPath


        Dim sqliteCon As New sqliteRead(str)



        Try

            dg_msgmenu.DataSource = sqliteCon.getDataSms("select _id,address as SENDER,body as INBOX from sms where address='" + dbKey + "';").Tables(0)

            'dg_msgmenu.Columns(0).Visible = False

            With cbo_status
                .DataSource = temp_con.Query("select * from status_sm").Tables(0)
                .ValueMember = "sm_status_no"
                .DisplayMember = "name"
            End With



        Catch ex As Exception

            MessageBox.Show(ex.ToString)

            '  Console.WriteLine(ex.ToString)

        End Try


    End Sub

    Private Sub ChromeButton14_Click(sender As Object, e As EventArgs) Handles ChromeButton14.Click

        num_limit = txtLimit.Text

        MsgBox("Limit is set to " + txtLimit.Text)




    End Sub

   
    Private Sub Timer1_Tick(sender As Object, e As EventArgs) Handles Timer1.Tick


        If Not BackgroundWorker1.IsBusy Then
            BackgroundWorker1.RunWorkerAsync()


        End If

        




    End Sub
End Class
