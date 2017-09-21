Public Class command_console

    Dim myprocess As New Process
    Dim StartInfo As New System.Diagnostics.ProcessStartInfo
    Dim SR As System.IO.StreamReader
    Dim SW As System.IO.StreamWriter



    Sub New()

        StartInfo.FileName = "cmd" 'starts cmd window
        StartInfo.RedirectStandardInput = True
        StartInfo.RedirectStandardOutput = True

        StartInfo.UseShellExecute = False 'required to redirect
        StartInfo.CreateNoWindow = True '<---- creates no window, obviously

    End Sub

    Public Sub sendCommand(str As String, dur As Integer)

        StartInfo.Arguments = str

        myprocess.StartInfo = StartInfo
        myprocess.Start()
        SR = myprocess.StandardOutput
        SW = myprocess.StandardInput

        myprocess.WaitForExit(dur)



    End Sub


    Public Function getDevices() As ArrayList


        Shell("adb devices", AppWinStyle.Hide, True)

        sendCommand("/c adb devices", 5000)

        Dim devices As New ArrayList



        Dim op As String() = SR.ReadToEnd.ToString.Split(New String() {Environment.NewLine}, StringSplitOptions.None)

        SW.Close()
        SR.Close()

        Dim count = 0
        For Each strs In op

            If count > 0 Then

                Dim str_f = strs.Replace(vbCr, "").Replace(vbLf, "")

                If str_f.Contains("device") Then
                    devices.Add(str_f.Split(":")(0))
                    'MessageBox.Show(str_f.Split(":")(0))
                End If

            End If

            count = count + 1

        Next




        'myprocess.Kill()


        Return devices

    End Function

    Public Function getReply(cmd_str As String, ip_add As String, tme As Integer) As ArrayList

        Shell("adb  devices", AppWinStyle.Hide, True)

        sendCommand("/c adb -s" + ip_add + " " + cmd_str, tme)



        Dim op As String() = SR.ReadToEnd.ToString.Split(New String() {Environment.NewLine}, StringSplitOptions.None)

        Dim return_array As New ArrayList

        For Each strz In op

            return_array.Add(strz.Replace(vbCr, "").Replace(vbLf, ""))

        Next


        SW.Close()
        SR.Close()



        Return return_array

    End Function
    Public Function comREply(cmd_str As String) As ArrayList



        sendCommand("/c " + cmd_str, 2)



        Dim op As String() = SR.ReadToEnd.ToString.Split(New String() {Environment.NewLine}, StringSplitOptions.None)

        Dim return_array As New ArrayList

        For Each strz In op

            return_array.Add(strz.Replace(vbCr, "").Replace(vbLf, ""))

        Next


        SW.Close()
        SR.Close()



        Return return_array

    End Function



End Class
