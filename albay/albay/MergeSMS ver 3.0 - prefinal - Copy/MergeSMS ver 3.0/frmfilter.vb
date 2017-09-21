Public Class frmfilter

    Public smsBody As String
    Public filterName As String
    Public sms_statusId As String

    Private Sub frmfilter_Load(sender As Object, e As EventArgs) Handles MyBase.Load
        disPlayControl()
    End Sub

    Private Sub disPlayControl()


        Dim count = 0

        pnl_message_arr.Controls.Clear()

        Dim arr = smsBody.ToString.Split(" ")



        For Each arr_i As String In arr


            Dim a As New Panel

            a.Name = count.ToString
            a.BackColor = Color.AliceBlue
            a.Height = 40
            a.Width = 540
            a.Location = New Point(0, (count * 40))
            a.BorderStyle = BorderStyle.FixedSingle


            Dim p As New ComboBox
            With p
                p.DataSource = temp_con.Query("SELECT `COLUMN_NAME` as columns,DATA_TYPE " + _
                                       "FROM `INFORMATION_SCHEMA`.`COLUMNS` " + _
                                       "WHERE `TABLE_SCHEMA`='mergesms' " + _
                                       "AND `TABLE_NAME`='transaction_sm' limit 1,18446744073709551615;").Tables(0)
                p.DisplayMember = "columns"

                p.Name = "cbo_offset"
                p.Width = 120
                p.ValueMember = "DATA_TYPE"
                p.Location = New Point(200, 10)

            End With

            Dim chk As New CheckBox
            chk.Text = "Static"
            chk.Name = "static"
            chk.Width = 60
            chk.Location = New Point(350, 10)
            AddHandler chk.Click, AddressOf chks

            Dim chkEx As New CheckBox
            chkEx.Text = "Exclude"
            chkEx.Name = "exclude"
            chkEx.Location = New Point(420, 10)
            AddHandler chkEx.Click, AddressOf chksEx


            Dim b As New Label
            With b
                b.Text = arr_i
                b.Name = "offset"
                b.ForeColor = Color.Red
                b.Location = New Point(30, 10)
                b.Width = 120
                b.Font = New Font("Segoi UI", 9, FontStyle.Bold)
            End With

            Dim j As New Label
            With b
                j.Text = (count + 1).ToString + "  "
                j.ForeColor = Color.Black
                j.Location = New Point(5, 10)
            End With

            a.Controls.Add(b)
            a.Controls.Add(j)
            a.Controls.Add(p)
            a.Controls.Add(chk)
            a.Controls.Add(chkEx)

            pnl_message_arr.Controls.Add(a)
            count = count + 1
            a.BackColor = Color.White
            b.BackColor = Color.White



        Next
    End Sub


    Private Sub chks(sender As Object, e As EventArgs)

        Dim x = CType(sender, CheckBox)

        If (x.Checked) Then

            For Each ctr As Control In x.Parent.Controls

                If TypeOf ctr Is ComboBox Then
                    CType(ctr, ComboBox).SelectedIndex = -1
                    ctr.Enabled = False
                End If

            Next


        Else


            For Each ctr As Control In x.Parent.Controls

                If TypeOf ctr Is ComboBox Then

                    CType(ctr, ComboBox).SelectedIndex = 0
                    ctr.Enabled = True
                End If

            Next

        End If


    End Sub

    Private Sub HoverR(sender As Object, e As EventArgs)




        If TypeOf sender Is Label Then
            CType(sender, Label).Parent.BackColor = Color.AliceBlue
        Else
            CType(sender, Panel).BackColor = Color.AliceBlue
        End If

    End Sub


    Private Sub chksEx(sender As CheckBox, e As EventArgs)

        If sender.Checked Then
            sender.Parent.Controls.Find("cbo_offset", True)(0).Enabled = False
            sender.Parent.Controls.Find("static", True)(0).Enabled = False
        Else
            sender.Parent.Controls.Find("cbo_offset", True)(0).Enabled = True
            sender.Parent.Controls.Find("static", True)(0).Enabled = True
        End If




    End Sub

    Private Sub ChromeThemeContainer1_Click(sender As Object, e As EventArgs)

    End Sub


    Private Sub ChromeButton12_Click(sender As Object, e As EventArgs) Handles ChromeButton12.Click



        temp_con.NonQuery("insert into config_sm_type(name,sm_status_no) values('" + filterName.ToString + "'," + sms_statusId.ToString + ")")

        Dim id = temp_con.Query("select config_sm_type_no from config_sm_type order by config_sm_type_no desc limit 1").Tables(0).Rows.Item(0).Item(0).ToString()



        For Each ctr As Control In pnl_message_arr.Controls

            If TypeOf ctr Is Panel Then



                Dim p As Panel = CType(ctr, Panel)

                Dim ck As CheckBox = p.Controls.Find("exclude", True)(0)

                If ck.Checked Then
                    Continue For
                Else
                    Dim c = CType(ctr, Panel).Controls.Find("static", True)

                    Dim offset = ctr.Name.ToString
                    Dim val = CType(CType(ctr, Panel).Controls.Find("offset", True)(0), Label).Text
                    Dim columns = CType(CType(ctr, Panel).Controls.Find("cbo_offset", True)(0), ComboBox).Text
                    Dim columns_type = CType(CType(ctr, Panel).Controls.Find("cbo_offset", True)(0), ComboBox).SelectedValue



                    If CType(c(0), CheckBox).Checked Then

                        ' UPdate///////////////////////////////////////////////////////////////////////////////////////////////////////////////

                        If temp_con.NonQuery("insert into config_sm(offset,value,config_sm_type_no,static) values(" + offset + ",'" + val.ToString + "'," + _
                                     id + ",1)") < 0 Then

                            MessageBox.Show("Error")
                        Else
                            MessageBox.Show("Owrayt")
                        End If

                    Else


                        If temp_con.NonQuery("insert into config_sm(offset,value,config_sm_type_no,static,data_spec) values(" + offset + ",'" + columns.ToString + "'," + _
                                   id + ",0,'" + columns_type.ToString + "')") < 0 Then

                            MessageBox.Show("Error")
                        Else
                            MessageBox.Show("Owrayt")
                        End If


                    End If

                End If





            End If



        Next

        Me.Close()

    End Sub
End Class