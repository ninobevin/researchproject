Module global_access

    Public location_dt As DataSet

    Public converter_money As New converter


    Public temp_con As New connection_data_thread

    Public k_thread As New connection_data_thread

    Dim ini_f = New IniFile

    Public MINIMUM_AMOUNT_OUTGOING As Double
    Public MINIMUM_AMOUNT_INCOMING As Double
    Public MINIMUM_CHARGE_OUTGOING As Double
    Public MINIMUM_CHARGE_INCOMING As Double
    Public storename As String
    Public SMARTMoneyLimit As String
    Public phoneNo As String


    Public db_con_server As String
    Public db_con_user As String
    Public db_con_pass As String
    Public db_con_db As String


    Public sqlite_db_path As String
    Public sqlite_db_name As String



    Public theme_color As Color = System.Drawing.ColorTranslator.FromHtml("#28C758")
    Public theme_color_dark As Color = System.Drawing.ColorTranslator.FromHtml("#383838")
    Public theme_color_dark_forecolor As Color = System.Drawing.ColorTranslator.FromHtml("#FFFFFF")
    Public theme_color_back As Color = System.Drawing.ColorTranslator.FromHtml("#1FC451")
    Public theme_color_back2 As Color = System.Drawing.ColorTranslator.FromHtml("#009CDE")
    Public theme_color_back3 As Color = System.Drawing.ColorTranslator.FromHtml("#009CDE")
    Public cust_dt As DataSet
    Public branch_dt As DataSet
    '#009CDE
    Public font_description = New System.Drawing.Font("Segoe UI", 9.75)
    Public font_description_small = New System.Drawing.Font("Segoe UI", 8)
    Public font_description_bold = New System.Drawing.Font("Verdana", 9.75, FontStyle.Bold)
    Public font_header = New System.Drawing.Font("Segoe UI", 13)

    Public phoneType As Integer


    Public Function toMoneyPeso(str As String) As String
        Return "₱" & " " & (Double.Parse(str)).ToString("f2")
    End Function


    Public Function initiate_connection()

        Try



            'file that is loaded from settings.ini

            ini_f.Load("C:\MergePoint\settings.ini")

            Dim sec = ini_f.GetSection("db_setting")

            Dim chrge = ini_f.GetSection("computation")

            Dim management = ini_f.GetSection("management")

            Dim sqlite_sec = ini_f.GetSection("sqlite_setting")


            db_con_server = sec.GetKey("server").Value
            db_con_user = sec.GetKey("user").Value
            db_con_pass = sec.GetKey("pass").Value
            db_con_db = sec.GetKey("db").Value
            storename = management.GetKey("store_name").value
            phoneNo = management.GetKey("phone").value



            sqlite_db_path = sqlite_sec.GetKey("path").Value



            MINIMUM_AMOUNT_OUTGOING = chrge.GetKey("min_out_amt").Value
            MINIMUM_AMOUNT_INCOMING = chrge.GetKey("min_in_amt").Value
            MINIMUM_CHARGE_OUTGOING = chrge.GetKey("min_out_charge").Value
            MINIMUM_CHARGE_INCOMING = chrge.GetKey("min_in_charge").Value

            k_thread.mysqlCon()






        Catch ex As Exception

            Return -1

        End Try


        Return 1


    End Function





    Public Function toMoney(str As String) As Decimal


        Dim initialString As String = str
        Dim nonNumericCharacters As New System.Text.RegularExpressions.Regex("[^0-9.]")
        Dim numericOnlyString As String = nonNumericCharacters.Replace(initialString, String.Empty)

        Return CType(numericOnlyString, Decimal)

    End Function
    Public Function toInteger(str As String) As String




        Dim initialString As String = str
        Dim nonNumericCharacters As New System.Text.RegularExpressions.Regex("[^0-9]")
        Dim numericOnlyString As String = nonNumericCharacters.Replace(initialString, String.Empty)

        Return numericOnlyString




    End Function

    Public Function initiate_data_grid() As DataGridView



        Dim data_grid_global As New DataGridView


        With data_grid_global
            .EnableHeadersVisualStyles = False
            .Font = font_description
            .AutoSizeColumnsMode = DataGridViewAutoSizeColumnsMode.Fill
            .BackgroundColor = Color.White
            .RowHeadersBorderStyle = DataGridViewHeaderBorderStyle.Raised
            .SelectionMode = DataGridViewSelectionMode.FullRowSelect
            .RowHeadersVisible = False
            .DefaultCellStyle.SelectionBackColor = Color.DarkGray
            .BorderStyle = BorderStyle.None
            .ColumnHeadersDefaultCellStyle.Font = font_header
            .ColumnHeadersDefaultCellStyle.BackColor = theme_color_dark
            .ColumnHeadersDefaultCellStyle.ForeColor = theme_color_dark_forecolor
            .RowsDefaultCellStyle.SelectionForeColor = Color.Red
            '.RowsDefaultCellStyle.Font = New Font("Verdana", 12, FontStyle.Bold)

            .AllowUserToAddRows = False
            .CellBorderStyle = DataGridViewCellBorderStyle.None
            .AllowUserToResizeRows = False
            .ColumnHeadersBorderStyle = DataGridViewHeaderBorderStyle.None
            .ColumnHeadersHeight = 40
            .ScrollBars = ScrollBars.Both
            .Anchor = AnchorStyles.Left Or AnchorStyles.Right Or AnchorStyles.Bottom Or AnchorStyles.Top
            .EditMode = DataGridViewEditMode.EditProgrammatically


        End With


        AddHandler data_grid_global.MouseLeave, AddressOf dg_lost_focus

        data_grid_global.ClearSelection()





        Return data_grid_global


    End Function


    Public Function getNetworkCharge(amt As Decimal) As Decimal

        If amt > 50500.0 Then

            Return 252.5

        End If



        Try
            Dim row_data_2 = k_thread.Query("select charge from sm_net_charge where amount >=  " + amt.ToString + " order by network_charge_no limit 1").Tables(0).Rows

            Return row_data_2(0).Item(0)

        Catch ex As Exception



        End Try

        Return 0.0

    End Function
    Public Function getNetworkChargeId(amt As Decimal) As Integer
        'this is the limit amount to charge
        If amt > 50500.0 Then

            Return 102

        End If

        Try
            Dim row_data_2 = k_thread.Query("select network_charge_no from sm_net_charge where amount >=  " + amt.ToString + "order by network_charge_no limit 1").Tables(0).Rows

            Return row_data_2(0).Item(0)

        Catch ex As Exception

        End Try

        Return 0.0

    End Function

    Public Function getServiceCahrge(account As String, amount As Decimal, incoming As Integer) As String




        Dim result = ""




        Try
            If incoming = 1 Then


                If amount <= MINIMUM_AMOUNT_INCOMING Then

                    result = MINIMUM_CHARGE_INCOMING

                Else

                    Dim percentage As Decimal = k_thread.Query("select a.incoming from computation_sm a join account_sm b on a.account_no=b.account_no where b.name='" + account + "' or b.account_id='" + account + "'").Tables(0).Rows(0).Item(0)

                    result = Format(Math.Truncate(percentage * amount), "0.00")
                End If



            Else


                Dim basePointAmount = MINIMUM_AMOUNT_OUTGOING
                Dim basePointCharge = MINIMUM_CHARGE_OUTGOING


                'If amount <= basePointAmount + 300 Then


                '    'result = Format(basePointCharge, "0.00")

                '    If amount <= 700 Then

                '        result = Format(15, "0.00")
                '    ElseIf amount <= 800 Then
                '        result = Format(20, "0.00")
                '    ElseIf amount <= 1000 Then
                '        result = Format(25, "0.00")

                '    End If


                'Else

                '    If amount <= 8000 Then



                '        basePointCharge = basePointCharge + 10

                '        Do
                '            If basePointAmount + 300 < amount Then

                '                basePointAmount = basePointAmount + 500.0

                '                basePointCharge = basePointCharge + 12.5

                '            Else
                '                Exit Do

                '            End If

                '        Loop

                '        result = Format(basePointCharge, "0.00")

                '    Else
                '        Dim percentage As Decimal = k_thread.Query("select a.outgoing from computation_sm a join account_sm b on a.account_no=b.account_no where b.name='" + account + "'").Tables(0).Rows(0).Item(0)

                '        result = Format(Math.Truncate(percentage * amount), "0.00")

                '    End If

                'End If


                '/////////////////this for standard charge

                If amount <= MINIMUM_AMOUNT_OUTGOING Then

                    result = MINIMUM_CHARGE_OUTGOING

                Else

                    Dim percentage As Decimal = k_thread.Query("select a.outgoing from computation_sm a join account_sm b on a.account_no=b.account_no where b.name='" + account + "'").Tables(0).Rows(0).Item(0)

                    result = Format(Math.Truncate(percentage * amount), "0.00")

                End If
                '/////////////////this for standard charge



            End If



        Catch ex As Exception

            Console.WriteLine("Error account computation (SENT)")
            Console.WriteLine(ex.ToString)

        End Try

        Return result

    End Function

    Public Function getMyTime() As String


        Return DateTime.Now.ToString("yyyy-MM-dd") + " " + DateTime.Now.ToString("HH:mm:ss")


    End Function

    Public Function toDbDate(date_to_convert As DateTime) As String


        Return date_to_convert.ToString("yyyy-MM-dd") + " " + date_to_convert.ToString("HH:mm:ss")


    End Function
    Public Function toDbDateNoTime(date_to_convert As Date) As String


        Return date_to_convert.ToString("yyyy-MM-dd")


    End Function



    Public Function AccountToIp(ips As String) As String()

        Try
            Dim ret_ip = temp_con.Query("select a.ip_address as ip_address from general_account_add a join general_account b " + _
                                 " on a.account_no=b.account_no where b.name='" + ips + "' limit 1").Tables(0).Rows(0)("ip_address").ToString

            Dim ret_phone = temp_con.Query("select a.phonetype as phonetype from general_account_add a join general_account b " + _
              " on a.account_no=b.account_no where b.name='" + ips + "' limit 1").Tables(0).Rows(0)("phonetype").ToString



            Return {ret_ip, ret_phone}
        Catch ex As Exception
            Console.WriteLine(ex.ToString)
            MessageBox.Show("No ip has been established")
            Return {"000.000.0.000", "0"}

        End Try





    End Function



    Public Function checkIP(ips As String) As Boolean

        Try
            Dim cmds As New command_console

            For Each devs In cmds.getDevices()

                If ips.Equals(devs) Then
                    Return True
                End If

            Next


        Catch ex As Exception

        End Try



        Return False


    End Function

    Private Sub dg_lost_focus(sender As DataGridView, e As EventArgs)

        sender.ClearSelection()



    End Sub

    Public Function GetColByHeaderText(ByVal dgv As DataGridView, ByVal name As String) As Integer

        For Each col As DataGridViewColumn In dgv.Columns
            If col.HeaderText = name Then
                Return col.Index
            End If
        Next

        Return -1

    End Function

    Public Function send_sms(address_no As String, contents As String, ips As String) As Integer



        Dim string_arr = contents.Split(" ")

        string_arr(string_arr.Length - 2) = ""


        Dim res As String = String.Join(" ", string_arr)



        Shell("adb devices", AppWinStyle.Hide, True)

        Shell("adb -s " + ips + ":5555 shell am startservice --user 0 -n com.android.shellms/.sendSMS -e contact " + address_no + " -e msg '" + res + "'", AppWinStyle.NormalFocus, True)



        MsgBox("Message Sent.. please verify your phone inbox...")




        Return 1

    End Function

    Public Function getCashDiff() As String

        Dim l = temp_con.Query("call genReportTodaySmTEST ('" + Date.Now.ToString("yyyy-MM-dd") + "','12-12-2015')").Tables(0)

        Dim cash_difference = l.Compute(" (sum(SENT) + sum(DEPOSIT)) - (sum(CLAIMED) + sum(WITHDRAW)) ", "").ToString


        Try
            Return cash_difference
        Catch ex As Exception
            Return "0.00"
        End Try





    End Function

    Public Function getAllPending() As String

        Dim l = temp_con.Query("select sum(amount) from view_pending_sm;").Tables(0).Rows(0).Item(0)

        Dim cash_difference = l.ToString

        Try
            Return cash_difference
        Catch ex As Exception
            Return "0.00"
        End Try





    End Function

    Public Sub fill_branch_dt()


        branch_dt = temp_con.Query("Select branch_no,branch_name from branch")



    End Sub

    Public Function getPhoneIp() As String

        Return k_thread.Query("select ip_address from general_account_add where account_no= " & phoneNo & " limit 1").Tables(0).Rows(0)("ip_address").ToString


    End Function

    Public Function setPhoneIp(ip As String)

        Return k_thread.NonQuery("update general_account_add set ip_address='" + ip + "' where ip_address='" + getPhoneIp() + "' and account_no= " & phoneNo & ";")



    End Function


    Public Function sendSms(body As String, contactNo As String)

        Dim sendTo = contactNo.Split(",")

        For Each no As String In sendTo

            Shell("adb devices", AppWinStyle.Hide, True)

            Shell("adb -s " + getPhoneIp() + ":5555 shell am startservice --user 0 -n com.android.shellms/.sendSMS -e contact " + no + " -e msg '" + body + "' --esn secret", AppWinStyle.Hide, True)


        Next


        'Return isSend

    End Function


    Public Function sendMsg(body As String, contactNo As String)

        Dim sendTo = contactNo.Split(",")


        For Each no As String In sendTo






            Shell("adb -s " + getPhoneIp() + ":5555 shell am startservice --user 0 -n com.android.shellms/.sendSMS -e contact '" + no + "' -e msg '" + body + "'", AppWinStyle.Hide, True)


        Next


        'Return isSend

    End Function

End Module
