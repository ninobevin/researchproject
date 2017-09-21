Imports System.Data.SQLite
Imports MySql.Data.MySqlClient
Public Class connection_data_thread

    Dim j As New MySqlConnection





    Public Function getDataSms(SQLstr As String) As DataSet





        Dim connection As String = "Data Source=" + sqlite_db_path + "\mmssms.db;Version=3"
        Dim SQLConn As New SQLiteConnection
        Dim SQLcmd As New SQLiteCommand


        SQLConn.ConnectionString = connection
        SQLConn.Open()

        SQLcmd.Connection = SQLConn
        'SQLcmd.CommandText = SQLstr
        'SQLdr = SQLcmd.ExecuteReader()

        Dim sa As New SQLiteDataAdapter(SQLstr, SQLConn)

        Dim da As New DataSet

        sa.Fill(da)

        SQLConn.Close()

        Return da

    End Function

    Public Function mysqlCon() As Boolean

        Console.WriteLine("server=" + db_con_server + ";uid=" + db_con_user + ";pwd=" + db_con_pass + ";database=" + db_con_db + ";pooling=true;")

        j.ConnectionString = "server=" + db_con_server + ";uid=" + db_con_user + ";pwd=" + db_con_pass + ";database=" + db_con_db + ";pooling=true;"
        Try
            j.Open()



        Catch ex As Exception
            Console.WriteLine(ex.ToString)
            Return False
        End Try

        Return True
    End Function

    Public Function NonQuery(str As String) As Integer





        Dim command = New MySqlCommand

        command.CommandText = str

        command.Connection = j

        Try

            Dim x = command.ExecuteNonQuery()
            Return x


        Catch ex As MySqlException
            Console.WriteLine(str)


        End Try



        Return -1


    End Function
    Public Function NonQuery_thread(str As String) As Integer





        Dim command = New MySqlCommand

        command.CommandText = str

        command.Connection = j

        Try

            Dim x = command.ExecuteNonQuery()
            Return x


        Catch ex As MySqlException
            Console.WriteLine(str)


        End Try



        Return -1


    End Function

    Public Function Query(str As String) As DataSet


        Console.WriteLine(str)

        Try
            Dim sa As New MySqlDataAdapter(str, j)

            Dim da As New DataSet

            sa.Fill(da)

            Return da


        Catch ex As Exception
            MsgBox(ex.ToString)
        End Try




    End Function


    Public Function Query_thread(str As String) As DataSet

        Try
            Dim sa As New MySqlDataAdapter(str, j)

            Dim da As New DataSet

            sa.Fill(da)

            Return da


        Catch ex As Exception
            MessageBox.Show(ex.ToString)
        End Try

    End Function

    Public Function QueryRead(str As String) As MySqlDataReader


        Dim command = New MySqlCommand

        command.CommandText = str

        command.Connection = j

        Return command.ExecuteReader



    End Function




End Class
